<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador para verificación de email.
 *
 * Maneja la verificación del correo electrónico del usuario
 * mediante el enlace enviado a su bandeja de entrada.
 *
 * @package App\Http\Controllers\Auth
 */
class VerifyEmailController extends Controller
{
  /**
   * Marca el email del usuario autenticado como verificado.
   *
   * Verifica si el email ya está verificado. Si no lo está,
   * intenta marcarlo como verificado y dispara el evento.
   *
   * @param  EmailVerificationRequest  $request Request con lógica de verificación.
   *
   * @return RedirectResponse Redirige al dashboard con parámetro verified=1.
   */
  public function __invoke(EmailVerificationRequest $request): RedirectResponse
  {
    if ($request->user()->hasVerifiedEmail()) {
      return redirect()->intended(
        route('dashboard', absolute: false) . '?verified=1',
      );
    }

    if ($request->user()->markEmailAsVerified()) {
      event(new Verified($request->user()));
    }

    return redirect()->intended(
      route('dashboard', absolute: false) . '?verified=1',
    );
  }
}
