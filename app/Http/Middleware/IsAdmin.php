<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar rol de administrador.
 *
 * Verifica que el usuario autenticado tenga el rol 'admin'.
 * Redirige al dashboard si el usuario no tiene permisos de administrador.
 *
 * @package App\Http\Middleware
 */
class IsAdmin
{
  /**
   * Maneja una petición entrante.
   *
   * Verifica si el usuario autenticado posee el rol 'admin'.
   * Si no tiene el rol, redirige a la ruta 'dashboard'.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (Auth::user()->role->name !== 'admin') {
      return redirect()->route('dashboard');
    }
    return $next($request);
  }
}
