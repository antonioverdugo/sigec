<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador para mostrar prompt de verificación de email.
 *
 * Verifica si el usuario ha verificado su correo electrónico.
 * Si no lo ha hecho, muestra la vista de verificación.
 *
 * @package App\Http\Controllers\Auth
 */
class EmailVerificationPromptController extends Controller
{
  /**
   * Muestra el prompt de verificación de email.
   *
   * Redirige al dashboard si el email ya está verificado.
   * Si no está verificado, muestra la vista de verificación.
   *
   * @param  Request  $request
   *
   * @return RedirectResponse|View
   */
  public function __invoke(Request $request): RedirectResponse|View
  {
    return $request->user()->hasVerifiedEmail()
      ? redirect()->intended(route('dashboard', absolute: false))
      : view('auth.verify-email');
  }
}
