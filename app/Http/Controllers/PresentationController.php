<?php

namespace App\Http\Controllers;

use App\Http\Requests\Presentation\CreatePresentationRequest;
use App\Http\Requests\Presentation\UpdatePresentationRequest;
use App\Models\Category;
use App\Models\Presentation;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Request;

class PresentationController extends Controller
{
  /**
   * Listar todas las presentaciones
   */
  public function index(): View
  {
    // Obtenemos el usuario autenticado
    $user = Auth::user();

    // Si es admin se muestran todas las presentaciones, si no solo las del usuario autenticado
    if ($user->role->name === 'admin') {
      $presentations = Presentation::paginate(8);
    } else {
      $presentations = Presentation::where('user_id', $user->id)->paginate(8);
    }

    return view('dashboard.presentations.index', compact('presentations'));
  }

  /**
   * Mostrar el formulario para crear una nueva presentación
   */
  public function create(User $user): View|RedirectResponse
  {
    $categories = Category::get();

    return view(
      'dashboard.presentations.create',
      compact('user', 'categories'),
    );
  }

  /**
   * Guardar una nueva presentación
   */
  public function store(CreatePresentationRequest $request, User $user)
  {
    $data = [
      'title' => $request->title,
      'summary' => $request->summary,
      'type_presentation_id' => 1,
      'user_id' => $user->id,
      'type_file' => $this->typePresentation(
        $request->file('file')->extension(),
      ),
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
    Presentation::create($data);

    return redirect()
      ->route('presentations.index')
      ->with('message', 'Ponencia creada correctamente')
      ->with('icon', 'success');
  }

  /**
   * Ver una presentación
   */
  public function show(Presentation $presentation)
  {
    //
  }

  /**
   * Mostrar el formulario para editar una presentación
   */
  public function edit(Presentation $presentation): View
  {
    $categories = Category::get();

    // Mostrar la vista para editar la presentación
    return view(
      'dashboard.presentations.edit',
      compact('presentation', 'categories'),
    );
  }

  /**
   * Actualizar una presentación
   */
  public function update(
    UpdatePresentationRequest $request,
    Presentation $presentation,
  ) {
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
      // Actualizar el tipo de archivo
      $data['type_file'] = $this->typePresentation(
        $request->file('file')->extension(),
      );
      $filename =
        // Guardar el archivo
        $filepath = $this->saveFile($presentation, $request);
      // Obtener la URL del archivo guardado
      $url = Storage::url($filepath);
      // Almacenar en el array la url
      $data['url_file'] = $url;
      // Eliminar el archivo anterior
      $this->deletePreviusFile($presentation->url_file);
    } else {
      // Cambiamos el nombre al archivo
      $path = $this->changeFileName($presentation, $request);
      $data['url_file'] = $path;
    }
    // Actualizar la ponencia
    Presentation::where('id', $presentation->id)->update($data);

    return redirect()
      ->route('presentations.index')
      ->with('message', 'Ponencia actualizada correctamente')
      ->with('icon', 'success');
  }

  /**
   * Eliminar una presentación
   */
  public function destroy(Presentation $presentation)
  {
    // Comprobar que existe la presentación
    $this->findPresentation($presentation->id);
    // Eliminar la presentación
    Presentation::where('id', $presentation->id)->delete();
    // Limpiar la url del archivo antes de eliminarlo
    $path = str_replace('/storage/', '', $presentation->url_file);
    // Eliminar el archivo asociado a la ponencia
    Storage::disk('public')->delete($path);

    // Redirigir al la vista de lista de presentaciones
    return redirect()
      ->route('presentations.index')
      ->with('message', 'Ponencia eliminada correctamente')
      ->with('icon', 'success');
  }

  /**
   * Método para comprobar que existe el ponencia
   */
  private function findPresentation(
    int $id,
  ): Presentation|ModelNotFoundException {
    return Presentation::findOrFail($id);
  }

  /**
   * Método para comprobar el tipo de archivo de la ponencia
   */
  private function typePresentation(string $fileExtension): string
  {
    $powerPointExtensions = ['ppt', 'pptx'];
    $type = 'KEYNOTE';
    if (strtolower($fileExtension) === 'pdf') {
      $type = 'PDF';
    } elseif (in_array(strtolower($fileExtension), $powerPointExtensions)) {
      $type = 'POWERPOINT';
    } elseif (strtolower($fileExtension) === 'odp') {
      $type = 'OPEN DOCUMENT';
    }

    return $type;
  }
  /**
   * Método para obtener el nombre de la ponencia
   */
  private function getFileName(
    Presentation|User $element,
    Request $request,
  ): string {
    // Obtener el id del usuario
    $userId =
      $element instanceof Presentation ? $element->user->id : $element->id;
    // $extension =
    //   $element instanceof Presentation
    //     ? pathinfo($element->url_file, PATHINFO_EXTENSION)
    //     : $request->file->extension();
    if ($request->file('file') !== null) {
      $extension = $request->file->extension();
    } else {
      $extension = pathinfo($element->url_file, PATHINFO_EXTENSION);
    }
    // Darle un nombre al archivo
    return $fileName =
      $userId .
      '-' .
      date('Y-m-d H:i:s-', time()) .
      $request->title .
      '.' .
      $extension;
  }
  /**
   * Método para guardar el archivo
   */
  private function saveFile(
    Presentation|User $element,
    Request $request,
  ): string {
    $userId =
      $element instanceof Presentation ? $element->user->id : $element->id;
    $userName =
      $element instanceof Presentation ? $element->user->name : $element->name;
    // Darle un nombre al archivo
    $fileName = $this->getFileName($element, $request);
    // Directorio donde se guardará el archivo
    $dirName = $userId . '-' . $userName;
    // Guardar el archivo en el directorio especificado
    return $filepath = $request
      ->file('file')
      ->storeAs('presentations/' . $dirName, $fileName, 'public');
  }

  /**
   * Método para eliminar la ponencia
   */
  private function deletePreviusFile(string $url)
  {
    $path = str_replace('/storage/', '', $url);
    Storage::disk('public')->delete($path);
  }
  /**
   * Método para cambiar el nombre a la ponencia
   */
  private function changeFileName(
    Presentation $presentation,
    Request $request,
  ): string {
    // Obtenemos el nuevo nombre
    $fileName = $this->getFileName($presentation, $request);
    // Obtenemos el path para guardar en la bd
    $pathBd = dirname($presentation->url_file) . '/' . $fileName;
    // Obtenemos el new path para cambiar el nombre al archivo
    $newPath = str_replace('/storage', '', $pathBd);
    $oldPath = str_replace('/storage', '', $presentation->url_file);
    Storage::disk('public')->move($oldPath, $newPath);
    return $pathBd;
  }
}
