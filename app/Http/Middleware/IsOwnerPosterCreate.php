<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar rol de ponente en creación de pósters.
 *
 * Verifica que el usuario autenticado tenga el rol 'ponente'.
 * Redirige al listado de pósters si el usuario no es ponente.
 *
 * @package App\Http\Middleware
 */
class IsOwnerPosterCreate
{
  /**
   * Maneja una petición entrante.
   *
   * Verifica si el usuario autenticado posee el rol 'ponente'.
   * Si no tiene el rol, redirige a la ruta 'posters.index'.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Comprobamos que el que crea un poster es un ponente
    if (Auth::user()->role->name !== 'ponente') {
      return redirect()->route('posters.index');
    }
    return $next($request);
  }
}
