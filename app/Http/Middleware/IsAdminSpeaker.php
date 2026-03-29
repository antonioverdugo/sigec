<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar rol de administrador o ponente.
 *
 * Verifica que el usuario autenticado tenga el rol 'admin' o 'ponente'.
 * Redirige al dashboard si el usuario no tiene ninguno de estos roles.
 *
 * @package App\Http\Middleware
 */
class IsAdminSpeaker
{
  /**
   * Maneja una petición entrante.
   *
   * Verifica si el usuario autenticado posee el rol 'admin' o 'ponente'.
   * Si no tiene ninguno de estos roles, redirige a la ruta 'dashboard'.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (
      Auth::user()->role->name !== 'admin' &&
      Auth::user()->role->name !== 'ponente'
    ) {
      return redirect()->route('dashboard');
    }
    return $next($request);
  }
}
