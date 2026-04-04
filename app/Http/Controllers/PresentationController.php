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
     * Controlador para la gestión de presentaciones (ponencias).
     *
     * Maneja las operaciones CRUD de presentaciones, incluyendo
     * creación, edición, eliminación, publicación y manejo de
     * archivos (PDF, PowerPoint, Keynote).
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
     * Muestra el formulario para crear una nueva presentación.
     *
     * Recupera las categorías disponibles para el formulario.
     *
     * @param  User  $user  Usuario autenticado.
     * @return View Vista del formulario de creación.
     *
     * @example GET /presentations/create
     */
    public function create(User $user): View
    {
        $categories = Category::get();

        return view(
            'dashboard.presentations.create',
            compact('user', 'categories'),
        );
    }

    /**
     * Guarda una nueva presentación en la base de datos.
     *
     * Valida los datos del request, asigna la categoría por
     * defecto si no se selecciona, determina el tipo de archivo
     * y guarda el archivo en storage.
     *
     * @param  CreatePresentationRequest  $request  Datos validados del formulario.
     * @param  User  $user  Usuario autenticado.
     * @return RedirectResponse Redirección a la lista con mensaje de éxito.
     *
     * @example POST /presentations
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
     * Muestra los detalles de una presentación específica.
     *
     * Método reservado para uso futuro.
     *
     * @param  Presentation  $presentation  Presentación a mostrar.
     *
     * @example GET /presentations/{presentation}
     */
    public function show(Presentation $presentation)
    {
        //
    }

    /**
     * Muestra el formulario para editar una presentación.
     *
     * Recupera las categorías disponibles para el formulario
     * de edición.
     *
     * @param  Presentation  $presentation  Presentación a editar.
     * @return View Vista del formulario de edición.
     *
     * @example GET /presentations/{presentation}/edit
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
     * Actualiza una presentación existente.
     *
     * Valida los datos del request, actualiza los campos de
     * texto y el archivo si se proporciona uno nuevo. Detecta
     * el tipo de archivo y actualiza el nombre si cambia el título.
     *
     * @param  UpdatePresentationRequest  $request  Datos validados del formulario.
     * @param  Presentation  $presentation  Presentación a actualizar.
     * @return RedirectResponse Redirección a la lista con mensaje de éxito.
     *
     * @example PUT /presentations/{presentation}
     */
    public function update(
        UpdatePresentationRequest $request,
        Presentation $presentation,
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
     * Elimina una presentación y su archivo asociado.
     *
     * Verifica que la presentación exista, la elimina de la
     * base de datos y elimina el archivo del storage.
     *
     * @param  Presentation  $presentation  Presentación a eliminar.
     * @return RedirectResponse Redirección a la lista con mensaje de éxito.
     *
     * @example DELETE /presentations/{presentation}
     */
    public function destroy(Presentation $presentation): RedirectResponse
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
     * Publica o despublica una presentación.
     *
     * Cambia el estado 'published' de la presentación.
     *
     * @param  Presentation  $presentation  Presentación a publicar/despublicar.
     * @return RedirectResponse Redirección con mensaje de resultado.
     *
     * @example POST /presentations/{presentation}/publish
     */
    public function publish(Presentation $presentation): RedirectResponse
    {
        if ($presentation->published) {
            Presentation::where('id', $presentation->id)->update([
                'published' => false,
            ]);

            return redirect()
                ->route('presentations.index')
                ->with('message', 'Ponencia despublicada correctamente')
                ->with('icon', 'success');
        } else {
            Presentation::where('id', $presentation->id)->update([
                'published' => true,
            ]);

            return redirect()
                ->route('presentations.index')
                ->with('message', 'Ponencia publicada correctamente')
                ->with('icon', 'success');
        }
    }

    /**
     * Busca una presentación por su ID.
     *
     * @param  int  $id  ID de la presentación a buscar.
     * @return Presentation|ModelNotFoundException Presentación encontrada.
     *
     * @throws ModelNotFoundException Si la presentación no existe.
     */
    private function findPresentation(
        int $id,
    ): Presentation|ModelNotFoundException {
        return Presentation::findOrFail($id);
    }

    /**
     * Determina el tipo de archivo de la presentación.
     *
     * Clasifica el archivo según su extensión en:
     * - PDF
     * - POWERPOINT (ppt, pptx)
     * - OPEN DOCUMENT (odp)
     * - KEYNOTE (por defecto)
     *
     * @param  string  $fileExtension  Extensión del archivo.
     * @return string Tipo de presentación en mayúsculas.
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
     * Genera un nombre único para el archivo de la presentación.
     *
     * Formato: {userId}-{fecha}-{titulo}.{extension}
     *
     * @param  Presentation|User  $element  Presentación o usuario para obtener el ID.
     * @param  Request  $request  Request con el título y archivo.
     * @return string Nombre del archivo generado.
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
          $userId.
          '-'.
          date('Y-m-d H.i.s-', time()).
          $request->title.
          '.'.
          $extension;
    }

    /**
     * Guarda el archivo de la presentación.
     *
     * Crea el directorio si no existe y guarda el archivo
     * en storage/app/public/presentations/{userId-userName}/.
     *
     * @param  Presentation|User  $element  Presentación o usuario.
     * @param  Request  $request  Request con el archivo.
     * @return string Ruta relativa donde se guardó el archivo.
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
        $dirName = $userId.'-'.$userName;

        // Guardar el archivo en el directorio especificado
        return $filepath = $request
            ->file('file')
            ->storeAs('presentations/'.$dirName, $fileName, 'public');
    }

    /**
     * Elimina el archivo anterior de la presentación.
     *
     * @param  string  $url  URL completa del archivo a eliminar.
     */
    private function deletePreviusFile(string $url)
    {
        $path = str_replace('/storage/', '', $url);
        Storage::disk('public')->delete($path);
    }

    /**
     * Cambia el nombre del archivo al actualizar la presentación.
     *
     * Renombra el archivo existente manteniendo la misma
     * ubicación pero con el nuevo título.
     *
     * @param  Presentation  $presentation  Presentación con el archivo actual.
     * @param  Request  $request  Request con el nuevo título.
     * @return string Nueva ruta del archivo para la BD.
     */
    private function changeFileName(
        Presentation $presentation,
        Request $request,
    ): string {
        // Obtenemos el nuevo nombre
        $fileName = $this->getFileName($presentation, $request);
        // Obtenemos el path para guardar en la bd
        $pathBd = dirname($presentation->url_file).'/'.$fileName;
        // Obtenemos el new path para cambiar el nombre al archivo
        $newPath = str_replace('/storage', '', $pathBd);
        $oldPath = str_replace('/storage', '', $presentation->url_file);
        Storage::disk('public')->move($oldPath, $newPath);

        return $pathBd;
    }
}
