<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsPublishedPosterShow
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
    // Si el poster no está publicado se redirecciona y no se muestra
    if (!$poster->published) {
      return redirect()->route('posters.public');
    }
    return $next($request);
  }
}
