<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * Controlador para registro de nuevos usuarios.
 *
 * Maneja el proceso de registro de usuarios en el sistema,
 * incluyendo validación, creación de cuenta y autenticación automática.
 *
 * @package App\Http\Controllers\Auth
 */
class RegisteredUserController extends Controller
{
  /**
   * Muestra la vista de registro.
   *
   * @return View Vista del formulario de registro.
   */
  public function create(): View
  {
    return view('auth.register');
  }

  /**
   * Procesa la solicitud de registro.
   *
   * Valida los datos del nuevo usuario, crea la cuenta,
   * dispara el evento de registro y autentica al usuario.
   *
   * @param  Request  $request
   *
   * @return RedirectResponse Redirige al dashboard.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => [
        'required',
        'string',
        'lowercase',
        'email',
        'max:255',
        'unique:' . User::class,
      ],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
  }
}
