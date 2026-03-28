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

class PosterController extends Controller
{
  /**
   * Listar los posters según el rol del usuario.
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
   * Mostrar el formulario para crear un nuevo poster.
   */
  public function create(User $user): View
  {
    // Obtenemos las categorias para el formulario
    $categories = Category::get();

    return view('dashboard.posters.create', compact(['user', 'categories']));
  }

  /**
   * Método para almacenar un nuevo poster en la base de datos.
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
   * Método para mostrar un poster específico.
   */
  public function show(Poster $poster) {}

  /**
   * Método para mostrar el formulario de edición de un poster.
   */
  public function edit(Poster $poster): View
  {
    // Obtenemos las categorias
    $categories = Category::get();

    // Retornar la vista para editar un poster
    return view('dashboard.posters.edit', compact('poster', 'categories'));
  }

  /**
   * Método para actualizar un poster en la base de datos.
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
   * Método para eliminar un poster de la base de datos.
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
   * Método para filtrar los posters que han sido publicados
   */
  public function postersPublic(): View
  {
    $posters = Poster::where('published', 1)->paginate(8);
    $categories = Category::get();
    return view('posters.public', compact(['posters', 'categories']));
  }

  /**
   * Método para filtrar los posters
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
   * Método para comprobar que existe el poster
   */
  private function findPresentation(int $id): Poster|ModelNotFoundException
  {
    return Poster::findOrFail($id);
  }

  /**
   * Método para obtener el nombre del poster
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
   * Método para guardar el archivo
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
   * Método para publicar o despublicar una presentación
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
   * Método para eliminar el poster anterior
   */
  private function deletePreviusFile(string $url)
  {
    $path = str_replace('/storage/', '', $url);
    Storage::disk('public')->delete($path);
  }

  /**
   * Método para cambiar el nombre del archivo de la ponencia al actualizar
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
