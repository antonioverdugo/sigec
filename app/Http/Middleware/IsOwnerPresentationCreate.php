<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar rol de ponente en creación de presentaciones.
 *
 * Verifica que el usuario autenticado tenga el rol 'ponente'.
 * Redirige al listado de presentaciones si el usuario no es ponente.
 *
 * @package App\Http\Middleware
 */
class IsOwnerPresentationCreate
{
  /**
   * Maneja una petición entrante.
   *
   * Verifica si el usuario autenticado posee el rol 'ponente'.
   * Si no tiene el rol, redirige a la ruta 'presentations.index'.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (Auth::user()->role->name !== 'ponente') {
      return redirect()->route('presentations.index');
    }
    return $next($request);
  }
}
