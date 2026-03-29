<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controlador para gestión de sesiones autenticadas.
 *
 * Maneja las operaciones de autenticación de usuarios incluyendo
 * login, logout y visualización del formulario de inicio de sesión.
 *
 * @package App\Http\Controllers\Auth
 */
class AuthenticatedSessionController extends Controller
{
  /**
   * Muestra la vista de inicio de sesión.
   *
   * @return \Illuminate\View\View Vista del formulario de login.
   */
  public function create(): View
  {
    return view('auth.login');
  }

  /**
   * Procesa la solicitud de autenticación.
   *
   * Valida las credenciales del usuario, autentica la sesión
   * y regenera el token CSRF para seguridad.
   *
   * @param  LoginRequest  $request Request con credenciales validadas.
   *
   * @return RedirectResponse Redirige al dashboard o a la URL intentada.
   */
  public function store(LoginRequest $request): RedirectResponse
  {
    $request->authenticate();

    $request->session()->regenerate();

    return redirect()->intended(route('dashboard', absolute: false));
  }

  /**
   * Cierra la sesión autenticada.
   *
   * Invalida la sesión actual y regenera el token CSRF.
   * Redirige a la página principal.
   *
   * @param  Request  $request
   *
   * @return RedirectResponse Redirige a la página principal.
   */
  public function destroy(Request $request): RedirectResponse
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
  }
}
