<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar propiedad de la presentación en edición.
 *
 * Verifica que el usuario autenticado sea 'ponente' y propietario
 * de la presentación que intenta editar. Redirige al listado si no tiene permisos.
 *
 * @package App\Http\Middleware
 */
class IsOwnerPresentationEdit
{
  /**
   * Maneja una petición entrante.
   *
   * Obtiene la presentación de la ruta y verifica que el usuario autenticado
   * sea el propietario de la misma. Si no es ponente o no es propietario,
   * redirige a 'presentations.index'.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function handle(Request $request, Closure $next): Response
  {
    $presentation = $request->route('presentation');

    if (
      Auth::user()->role->name !== 'ponente' ||
      $presentation->user_id !== Auth::user()->id
    ) {
      return redirect()->route('presentations.index');
    }

    return $next($request);
  }
}
