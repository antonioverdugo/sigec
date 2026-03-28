<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsOwnerPosterEdit
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Obtenemos el poster
    $poster = $request->route('poster');

    // Comprobamos que el que modifica el poster es el usuario propietario
    if (
      Auth::user()->role->name !== 'ponente' ||
      $poster->user_id !== Auth::user()->id
    ) {
      return redirect()->route('posters.index');
    }
    return $next($request);
  }
}
