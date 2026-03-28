<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsOwnerPosterCreate
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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
