<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sponsor\CreateSponsorRequest;
use App\Http\Requests\Sponsor\UpdateSponsorRequest;
use App\Models\Sponsor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\TypeSponsor;

/**
 * Controlador para la gestión de patrocinadores.
 *
 * Maneja las operaciones CRUD de patrocinadores incluyendo
 * creación, edición, eliminación y listado de sponsors
 * con sus tipos correspondientes.
 *
 * @package App\Http\Controllers
 */
class SponsorController extends Controller
{
  /**
   * Lista todos los patrocinadores.
   *
   * Recupera los patrocinadores ordenados por fecha de
   * creación (más recientes primero) con su tipo
   * asociado, paginados de 8 en 8.
   *
   * @return View Vista con la lista de patrocinadores.
   *
   * @example GET /sponsors
   */
  public function index(): View
  {
    $sponsors = Sponsor::with('type_sponsor')
      ->orderBy('created_at', 'desc')
      ->paginate(8);
    return view('dashboard.sponsors.index', compact('sponsors'));
  }

  /**
   * Muestra el formulario para crear un patrocinador.
   *
   * Recupera todos los tipos de patrocinador disponibles
   * para el formulario de creación.
   *
   * @return View Vista del formulario de creación.
   *
   * @example GET /sponsors/create
   */
  public function create(): View
  {
    // Obtenemos todos los tipos de patrocinador
    $typeSponsors = TypeSponsor::get();
    // Retornamos la vista para crear los patrocinadores
    return view('dashboard.sponsors.create', compact('typeSponsors'));
  }

  /**
   * Guarda un nuevo patrocinador.
   *
   * Normaliza el nombre (capitaliza cada palabra),
   * valida los datos y crea el patrocinador.
   *
   * @param CreateSponsorRequest $request Datos validados del formulario.
   * @return RedirectResponse Redirección a la lista con mensaje de éxito.
   *
   * @example POST /sponsors
   */
  public function store(CreateSponsorRequest $request): RedirectResponse
  {
    // Crear el patrocinador
    Sponsor::create([
      'name' => ucwords(strtolower($request->name)),
      'email' => $request->email,
      'phone' => $request->phone,
      'amount_contributed' => $request->amount_contributed,
      'type_sponsor_id' => $request->type_sponsor_id,
    ]);

    // Redireccionar al listado de usuarios con mensaje de éxito
    return redirect()
      ->route('sponsors.index')
      ->with('message', 'Patrocinador creado exitosamente')
      ->with('icon', 'success');
  }

  /**
   * Muestra los detalles de un patrocinador.
   *
   * Redirige a la lista de patrocinadores ya que esta
   * vista no es necesaria en el sistema actual.
   *
   * @param Sponsor $sponsor Patrocinador a mostrar.
   * @return RedirectResponse Redirección a la lista de patrocinadores.
   *
   * @example GET /sponsors/{sponsor}
   */
  public function show(Sponsor $sponsor): RedirectResponse
  {
    return redirect()->route('sponsors.index');
  }

  /**
   * Muestra el formulario para editar un patrocinador.
   *
   * Verifica que el patrocinador exista y recupera
   * los tipos de patrocinador disponibles.
   *
   * @param int $id ID del patrocinador a editar.
   * @return View Vista del formulario de edición.
   *
   * @example GET /sponsors/{id}/edit
   */
  public function edit(int $id): View
  {
    // Comprobar que existe el patrocinador
    $sponsor = $this->findSponsor($id);
    // Obtenemos todos los tipos de patrocinador
    $typeSponsors = TypeSponsor::get();
    return view('dashboard.sponsors.edit', compact('sponsor', 'typeSponsors'));
  }

  /**
   * Actualiza un patrocinador existente.
   *
   * Valida los datos del request, normaliza el nombre
   * y actualiza el patrocinador en la base de datos.
   *
   * @param UpdateSponsorRequest $request Datos validados del formulario.
   * @param Sponsor $sponsor Patrocinador a actualizar.
   * @return RedirectResponse Redirección a la lista con mensaje de éxito.
   *
   * @example PUT /sponsors/{sponsor}
   */
  public function update(UpdateSponsorRequest $request, Sponsor $sponsor)
  {
    // Los datos se validad en UpdateSponsorRequest
    $sponsor->fill([
      'name' => ucwords(strtolower($request->name)),
      'email' => $request->email,
      'phone' => $request->phone,
      'amount_contributed' => $request->amount_contributed,
      'type_sponsor_id' => $request->type_sponsor_id,
    ]);

    // Actualizar el patrocinador
    $sponsor->save();

    // Redirigir a la lista de patrocinadores
    return redirect()
      ->route('sponsors.index')
      ->with('message', 'Patrocinador actualizado correctamente')
      ->with('icon', 'success');
  }

  /**
   * Elimina un patrocinador existente.
   *
   * Verifica que el patrocinador exista y lo
   * elimina de la base de datos.
   *
   * @param Sponsor $sponsor Patrocinador a eliminar.
   * @return RedirectResponse Redirección a la lista con mensaje de éxito.
   *
   * @example DELETE /sponsors/{sponsor}
   */
  public function destroy(Sponsor $sponsor): RedirectResponse
  {
    // Comprobar que el patrocinador existe
    $sponsorFind = $this->findSponsor($sponsor->id);

    // Eliminamos el patrocinador
    Sponsor::where('id', $sponsorFind->id)->delete();

    // Retornamos a la vista con el mensaje
    return redirect()
      ->route('sponsors.index')
      ->with('message', 'Patrocinador eliminado correctamente')
      ->with('icon', 'success');
  }

  /**
   * Busca un patrocinador por su ID.
   *
   * @param int $id ID del patrocinador a buscar.
   * @return Sponsor|ModelNotFoundException Patrocinador encontrado.
   *
   * @throws ModelNotFoundException Si el patrocinador no existe.
   */
  private function findSponsor(int $id): Sponsor|ModelNotFoundException
  {
    return Sponsor::findOrFail($id);
  }
}
