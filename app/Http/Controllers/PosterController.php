<?php

namespace App\Http\Controllers;

use App\Http\Requests\Poster\CreatePosterRequest;
use App\Http\Requests\Poster\UpdatePosterRequest;
use App\Models\Category;
use App\Models\Poster;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Controlador para la gestión de pósters.
 *
 * Maneja las operaciones CRUD de pósters, incluyendo creación,
 * edición, eliminación, publicación y búsqueda. Los usuarios
 * admin pueden ver todos los pósters mientras que los demás
 * solo ven los suyos propios.
 *
 * @package App\Http\Controllers
 */
class PosterController extends Controller
{
  /**
   * Lista los pósters según el rol del usuario.
   *
   * Si el usuario es admin, muestra todos los pósters.
   * De lo contrario, muestra solo los pósters del usuario
   * autenticado.
   *
   * @return View Vista con la lista de pósters.
   *
   * @example GET /posters
   */
  public function index(): View
  {
    // Obtener el usuario autenticado
    $user = Auth::user();
    // Si el usuario es admin, mostrar todos los posters, de lo contrario, mostrar solo los suyos
    if ($user->role->name === 'admin') {
      $posters = Poster::paginate(8);
    } else {
      $posters = Poster::where('user_id', $user->id)->paginate(8);
    }

    return view('dashboard.posters.index', compact(['posters']));
  }

  /**
   * Muestra el formulario para crear un nuevo póster.
   *
   * Recupera las categorías disponibles para el formulario
   * de creación.
   *
   * @param User $user Usuario autenticado.
   * @return View Vista del formulario de creación.
   *
   * @example GET /posters/create
   */
  public function create(User $user): View
  {
    // Obtenemos las categorias para el formulario
    $categories = Category::get();

    return view('dashboard.posters.create', compact(['user', 'categories']));
  }

  /**
   * Guarda un nuevo póster en la base de datos.
   *
   * Valida los datos del request, asigna la categoría por
   * defecto si no se selecciona ninguna, guarda el archivo
   * PDF y crea el póster.
   *
   * @param CreatePosterRequest $request Datos validados del formulario.
   * @param User $user Usuario autenticado.
   * @return RedirectResponse Redirección a la lista con mensaje de éxito.
   *
   * @example POST /posters
   */
  public function store(
    CreatePosterRequest $request,
    User $user,
  ): RedirectResponse {
    // Guardar los datos en el array data
    $data = [
      'title' => $request->title,
      'summary' => $request->summary,
      'type_presentation_id' => 2,
      'user_id' => $user->id,
    ];
    // Si no se selecciona una categoría, se asigna la categoría por defecto
    if ($request->category === null) {
      $data['category_id'] = 1;
    } else {
      $data['category_id'] = $request->category;
    }

    // Guardar el archivo y recibir el path
    $filepath = $this->saveFile($user, $request);
    // Obtener la URL del archivo guardado
    $url = Storage::url($filepath);
    // Almacenar en el array la url
    $data['url_file'] = $url;
    // Crear la presentación con los datos
    Poster::create($data);

    return redirect()
      ->route('posters.index')
      ->with('message', 'Poster creado correctamente')
      ->with('icon', 'success');
  }

  /**
   * Muestra los detalles de un póster individual.
   *
   * Recupera el póster a través de route model binding y
   * obtiene el nombre de su categoría para pasarlo a la
   * vista de detalle.
   *
   * @param Poster $poster Póster obtenido mediante route model binding.
   * @return View Vista con los detalles del póster.
   *
   * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
   *         Si el póster no existe.
   *
   * @example GET /posters/public/{poster}
   */
  public function show(Poster $poster): View
  {
    $category = $poster->category->name;
    return view('posters.show', compact(['poster', 'category']));
  }

  /**
   * Muestra el formulario para editar un póster.
   *
   * Recupera las categorías disponibles y retorna la
   * vista de edición con los datos del póster.
   *
   * @param Poster $poster Póster a editar.
   * @return View Vista del formulario de edición.
   *
   * @example GET /posters/{poster}/edit
   */
  public function edit(Poster $poster): View
  {
    // Obtenemos las categorias
    $categories = Category::get();

    // Retornar la vista para editar un poster
    return view('dashboard.posters.edit', compact('poster', 'categories'));
  }

  /**
   * Actualiza un póster existente.
   *
   * Valida los datos del request, actualiza los campos
   * de texto y el archivo si se proporciona uno nuevo.
   * Elimina el archivo anterior si se sube uno nuevo.
   *
   * @param UpdatePosterRequest $request Datos validados del formulario.
   * @param Poster $poster Póster a actualizar.
   * @return RedirectResponse Redirección a la lista con mensaje de éxito.
   *
   * @example PUT /posters/{poster}
   */
  public function update(
    UpdatePosterRequest $request,
    Poster $poster,
  ): RedirectResponse {
    // Datos de la actualización
    $data = [
      'title' => $request->title,
      'summary' => $request->summary,
    ];
    // Actualizar la categoria si es null
    if ($request->category === null) {
      $data['category_id'] = 1;
    } else {
      $data['category_id'] = $request->category;
    }

    // Si se ha enviado un archivo, actualizar el campo url_file
    if ($request->file('file') !== null) {
      $filename =
        // Guardar el archivo
        $filepath = $this->saveFile($poster, $request);
      // Obtener la URL del archivo guardado
      $url = Storage::url($filepath);
      // Almacenar en el array la url
      $data['url_file'] = $url;
      // Eliminar el archivo anterior
      $this->deletePreviusFile($poster->url_file);
    } else {
      // Cambiamos el nombre al archivo
      $path = $this->changeFileName($poster, $request);
      $data['url_file'] = $path;
    }
    // Actualizar la ponencia
    Poster::where('id', $poster->id)->update($data);

    // Redirigir y mostrar el resultado
    return redirect()
      ->route('posters.index')
      ->with('message', 'Poster actualizado correctamente')
      ->with('icon', 'success');
  }

  /**
   * Elimina un póster y su archivo asociado.
   *
   * Verifica que el póster exista, lo elimina de la
   * base de datos y elimina el archivo PDF del storage.
   *
   * @param Poster $poster Póster a eliminar.
   * @return RedirectResponse Redirección a la lista con mensaje de éxito.
   *
   * @example DELETE /posters/{poster}
   */
  public function destroy(Poster $poster)
  {
    // Comprobar que existe el poster
    $this->findPresentation($poster->id);
    // Eliminar el poster
    Poster::where('id', $poster->id)->delete();
    // Limpiar la url del archivo antes de eliminarlo
    $path = str_replace('/storage/', '', $poster->url_file);
    // Eliminar el archivo asociado al poster
    $prueba = Storage::disk('public')->delete($path);
    // Redirigir al la vista de los posters
    return redirect()
      ->route('posters.index')
      ->with('message', 'Poster eliminado correctamente')
      ->with('icon', 'success');
  }

  /**
   * Muestra los pósters publicados públicamente.
   *
   * Filtra y muestra solo los pósters con estado publicado,
   * junto con las categorías disponibles para filtrado.
   *
   * @return View Vista pública de pósters.
   *
   * @example GET /posters/public
   */
  public function postersPublic(): View
  {
    $posters = Poster::where('published', 1)->paginate(8);
    $categories = Category::get();
    return view('posters.public', compact(['posters', 'categories']));
  }

  /**
   * Busca y filtra pósters según criterios.
   *
   * Permite filtrar por título (búsqueda parcial) y/o
   * categoría. Retorna resultados paginados.
   *
   * @param Request $request Datos de búsqueda con 'title' y 'category'.
   * @return View Vista con los pósters filtrados.
   *
   * @example GET /posters/search?title=...&category=...
   */
  public function postersSearch(Request $request): View
  {
    // Obtenemos las categorias y los posters
    $categories = Category::get();
    $query = Poster::query();
    // Si $title tiene valor, agrega el WHERE
    $query->when(
      $request->title,
      fn($q) => $q->where('title', 'like', "%{$request->title}%"),
    );
    // Si $category tiene valor, agrega el WHERE
    $query->when(
      $request->category,
      fn($q) => $q->where('category_id', $request->category),
    );

    //Obtenemos los posters
    $posters = $query->paginate(8);
    return view('posters.public', compact(['posters', 'categories']));
  }

  /**
   * Busca un póster por su ID.
   *
   * @param int $id ID del póster a buscar.
   * @return Poster|ModelNotFoundException Póster encontrado.
   *
   * @throws ModelNotFoundException Si el póster no existe.
   */
  private function findPresentation(int $id): Poster|ModelNotFoundException
  {
    return Poster::findOrFail($id);
  }

  /**
   * Genera un nombre único para el archivo del póster.
   *
   * Formato: {userId}-{fecha}-titulo.pdf
   *
   * @param Poster|User $element Póster o usuario para obtener el ID.
   * @param Request $request Request con el título del póster.
   * @return string Nombre del archivo generado.
   */
  private function getFileName(Poster|User $element, Request $request): string
  {
    // Obtener el id del usuario
    $userId = $element instanceof Poster ? $element->user->id : $element->id;
    // Darle un nombre al archivo
    $fileName =
      $userId .
      '-' .
      date('Y-m-d H.i.s-', time()) .
      $request->title .
      '.' .
      'pdf';
    return $fileName;
  }

  /**
   * Guarda el archivo PDF del póster.
   *
   * Crea el directorio si no existe y guarda el archivo
   * en storage/app/public/posters/{userId-userName}/.
   *
   * @param Poster|User $element Póster o usuario.
   * @param Request $request Request con el archivo.
   * @return string Ruta relativa donde se guardó el archivo.
   */
  private function saveFile(Poster|User $element, Request $request): string
  {
    $userId = $element instanceof Poster ? $element->user->id : $element->id;
    $userName =
      $element instanceof Poster ? $element->user->name : $element->name;
    // Darle un nombre al archivo
    $fileName = $this->getFileName($element, $request);
    // Directorio donde se guardará el archivo
    $dirName = $userId . '-' . $userName;

    // Guardar el archivo en el directorio especificado
    return $filepath = $request
      ->file('file')
      ->storeAs('posters/' . $dirName, $fileName, 'public');
  }

  /**
   * Publica o despublica un póster.
   *
   * Cambia el estado 'published' del póster. Si está
   * publicado lo despublica y viceversa.
   *
   * @param Poster $poster Póster a publicar/despublicar.
   * @return RedirectResponse Redirección con mensaje de resultado.
   *
   * @example POST /posters/{poster}/publish
   */
  public function publish(Poster $poster)
  {
    if ($poster->published) {
      Poster::where('id', $poster->id)->update([
        'published' => false,
      ]);

      return redirect()
        ->route('posters.index')
        ->with('message', 'Poster despublicado correctamente')
        ->with('icon', 'success');
    } else {
      Poster::where('id', $poster->id)->update([
        'published' => true,
      ]);

      return redirect()
        ->route('posters.index')
        ->with('message', 'Poster publicado correctamente')
        ->with('icon', 'success');
    }
  }

  /**
   * Elimina el archivo anterior del póster.
   *
   * @param string $url URL completa del archivo a eliminar.
   *
   * @example Uso interno en update()
   */
  private function deletePreviusFile(string $url)
  {
    $path = str_replace('/storage/', '', $url);
    Storage::disk('public')->delete($path);
  }

  /**
   * Cambia el nombre del archivo al actualizar el póster.
   *
   * Renombra el archivo existente manteniendo la misma
   * ubicación pero con el nuevo nombre generado.
   *
   * @param Poster $poster Póster con el archivo actual.
   * @param Request $request Request con el nuevo título.
   * @return string Nueva ruta del archivo para la BD.
   */
  private function changeFileName(Poster $poster, Request $request): string
  {
    // Obtenemos el nuevo nombre
    $fileName = $this->getFileName($poster, $request);
    // Obtenemos el path para guardar en la bd
    $pathBd = dirname($poster->url_file) . '/' . $fileName;
    // Obtenemos el new path para cambiar el nombre al archivo
    $newPath = str_replace('/storage', '', $pathBd);
    $oldPath = str_replace('/storage', '', $poster->url_file);
    Storage::disk('public')->move($oldPath, $newPath);

    return $pathBd;
  }
}
