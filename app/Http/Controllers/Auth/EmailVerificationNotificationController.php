<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Controlador para envío de verificación de email.
 *
 * Maneja el reenvío del enlace de verificación de correo
 * electrónico cuando el usuario no lo ha recibido o ha expirado.
 *
 * @package App\Http\Controllers\Auth
 */
class EmailVerificationNotificationController extends Controller
{
  /**
   * Envía una nueva notificación de verificación de email.
   *
   * Verifica si el usuario ya tiene el email verificado.
   * Si no lo está, envía el enlace de verificación.
   * Retorna a la página anterior con mensaje de estado.
   *
   * @param  Request  $request
   *
   * @return RedirectResponse Redirige con mensaje de estado.
   */
  public function store(Request $request): RedirectResponse
  {
    if ($request->user()->hasVerifiedEmail()) {
      return redirect()->intended(route('dashboard', absolute: false));
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
  }
}
