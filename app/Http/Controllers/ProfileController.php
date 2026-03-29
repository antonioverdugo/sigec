<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

/**
 * Controlador para la gestión del perfil de usuario.
 *
 * Maneja la visualización, actualización y eliminación
 * de la cuenta del usuario autenticado.
 *
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
  /**
   * Muestra el formulario de edición del perfil.
   *
   * Retorna la vista con el formulario de perfil
   * del usuario autenticado.
   *
   * @param Request $request Request con el usuario autenticado.
   * @return View Vista del formulario de perfil.
   *
   * @example GET /profile
   */
  public function edit(Request $request): View
  {
    return view('profile.edit', [
      'user' => $request->user(),
    ]);
  }

  /**
   * Actualiza la información del perfil del usuario.
   *
   * Valida los datos del request, actualiza los campos
   * del usuario. Si el email cambia, invalida la
   * verificación del email.
   *
   * @param ProfileUpdateRequest $request Datos validados del formulario.
   * @return RedirectResponse Redirección al formulario con mensaje de éxito.
   *
   * @example PUT /profile
   */
  public function update(ProfileUpdateRequest $request): RedirectResponse
  {
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
      $request->user()->email_verified_at = null;
    }

    $request->user()->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
  }

  /**
   * Elimina la cuenta del usuario.
   *
   * Valida la contraseña actual, cierra la sesión,
   * elimina el usuario y regenera el token CSRF.
   *
   * @param Request $request Request con el usuario autenticado.
   * @return RedirectResponse Redirección a la página principal.
   *
   * @example DELETE /profile
   */
  public function destroy(Request $request): RedirectResponse
  {
    $request->validateWithBag('userDeletion', [
      'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
  }
}
