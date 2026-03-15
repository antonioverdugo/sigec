<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminSpeaker
{
  /**
   * Comprueba si el usuario tiene rol de admin o ponente sino redirige
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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
