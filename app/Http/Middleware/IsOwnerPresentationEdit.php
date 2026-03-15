<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsOwnerPresentationEdit
{
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
