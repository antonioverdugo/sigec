<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sponsor\CreateSponsorRequest;
use App\Http\Requests\Sponsor\UpdateSponsorRequest;
use App\Models\Sponsor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\TypeSponsor;

class SponsorController extends Controller
{
  /**
   * Método que lista todos los patrocinadores
   */
  public function index(): View
  {
    // if (auth()->user()->role->id !== 3) {
    //   return view('errors.access-denied');
    // }
    $sponsors = Sponsor::with('type_sponsor')
      ->orderBy('created_at', 'desc')
      ->paginate(8);
    return view('dashboard.sponsors.index', compact('sponsors'));
  }

  /**
   * Método que muestra la vista para crear un patrocinador
   */
  public function create(): View
  {
    // Obtenemos todos los tipos de patrocinador
    $typeSponsors = TypeSponsor::get();
    // Retornamos la vista para crear los patrocinadores
    return view('dashboard.sponsors.create', compact('typeSponsors'));
  }

  /**
   * Método que guarda un patrocinador
   */
  public function store(CreateSponsorRequest $request): RedirectResponse
  {
    // Crear el usuario
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
   * Método que muestra los datos de un patrocinador
   */
  public function show(Sponsor $sponsor): RedirectResponse
  {
    return redirect()->route('sponsors.index');
  }

  /**
   * Método que muestra la vista para actualizar un patrocinador
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
   * Método que actualiza en la bd los datos del patrocinador
   */
  public function update(UpdateSponsorRequest $request, Sponsor $sponsor)
  {
    // Los datos se validad en UpdateSponsorRequest
    $data = [
      'name' => ucwords(strtolower($request->name)),
      'phone' => $request->phone,
      'amount_contributed' => $request->amount_contributed,
      'type_sponsor_id' => $request->type_sponsor_id,
    ];
    // Si el email es distinto se actualiza ya que es unique
    if ($request->email !== $sponsor->email) {
      $data['email'] = $request->email;
    }

    // Actualizar el patrocinador
    Sponsor::where('id', $sponsor->id)->update($data);

    // Redirigir a la lista de patrocinadores
    return redirect()
      ->route('sponsors.index')
      ->with('message', 'Patrocinador actualizado correctamente')
      ->with('icon', 'success');
  }

  /**
   * Método para eliminar un patrocinador
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
   * Método para comprobar que existe el patrocinador
   */
  private function findSponsor(int $id): Sponsor|ModelNotFoundException
  {
    return Sponsor::findOrFail($id);
  }
}
