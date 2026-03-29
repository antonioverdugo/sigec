<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Controlador para actualización de contraseña.
 *
 * Maneja el cambio de contraseña del usuario autenticado,
 * validando la contraseña actual antes de establecer la nueva.
 *
 * @package App\Http\Controllers\Auth
 */
class PasswordController extends Controller
{
  /**
   * Actualiza la contraseña del usuario.
   *
   * Valida la contraseña actual y la nueva contraseña confirmada.
   * Si la validación es exitosa, actualiza la contraseña del usuario.
   *
   * @param  Request  $request
   *
   * @return RedirectResponse Redirige con mensaje de estado.
   */
  public function update(Request $request): RedirectResponse
  {
    $validated = $request->validateWithBag('updatePassword', [
      'current_password' => ['required', 'current_password'],
      'password' => ['required', Password::defaults(), 'confirmed'],
    ]);

    $request->user()->update([
      'password' => Hash::make($validated['password']),
    ]);

    return back()->with('status', 'password-updated');
  }
}
