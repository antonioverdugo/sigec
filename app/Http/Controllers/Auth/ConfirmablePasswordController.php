<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Controlador para confirmación de contraseña.
 *
 * Maneja la confirmación de contraseña antes de realizar
 * acciones sensibles como cambiar email o eliminar cuenta.
 *
 * @package App\Http\Controllers\Auth
 */
class ConfirmablePasswordController extends Controller
{
  /**
   * Muestra la vista de confirmación de contraseña.
   *
   * @return \Illuminate\View\View Vista del formulario de confirmación.
   */
  public function show(): View
  {
    return view('auth.confirm-password');
  }

  /**
   * Confirma la contraseña del usuario.
   *
   * Valida que la contraseña proporcionada coincida con la del usuario.
   * Si es correcta, guarda una marca de tiempo en la sesión para
   * permitir acciones sensibles sin nueva confirmación (15 minutos).
   *
   * @param  Request  $request
   *
   * @return RedirectResponse Redirige al dashboard o URL intentada.
   *
   * @throws ValidationException Si la contraseña es incorrecta.
   */
  public function store(Request $request): RedirectResponse
  {
    if (
      !Auth::guard('web')->validate([
        'email' => $request->user()->email,
        'password' => $request->password,
      ])
    ) {
      throw ValidationException::withMessages([
        'password' => __('auth.password'),
      ]);
    }

    $request->session()->put('auth.password_confirmed_at', time());

    return redirect()->intended(route('dashboard', absolute: false));
  }
}
