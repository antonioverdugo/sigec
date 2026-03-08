<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
    $sponsors = Sponsor::with('role')->orderBy('created_at', 'desc')->paginate(8);
    return view("dashboard.sponsors.index", compact("sponsors"));
  }

  /**
   * Método que muestra la vista para crear un patrocinador
   */
  public function create()
  {
    //
  }

  /**
   * Método que guarda un patrocinador
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Método que muestra los datos de un patrocinador
   */
  public function show(Sponsor $sponsor)
  {
    //
  }

  /**
   * Método que muestra la vista para actualizar un patrocinador
   */
  public function edit(Sponsor $sponsor)
  {
    //
  }

  /**
   * Método que actualiza en la bd los datos del patrocinador
   */
  public function update(Request $request, Sponsor $sponsor)
  {
    //
  }

  /**
   * Método para eliminar un patrocinador
   */
  public function destroy(Sponsor $sponsor)
  {
    //
  }
}
