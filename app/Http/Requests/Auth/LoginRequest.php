<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Request para autenticación de usuarios.
 *
 * Maneja la validación y autenticación de credenciales de login,
 * incluyendo protección contra ataques de fuerza bruta mediante
 * rate limiting.
 *
 * @package App\Http\Requests\Auth
 *
 * @property string $email Correo electrónico del usuario
 * @property string $password Contraseña del usuario
 * @property bool $remember Recordar sesión
 */
class LoginRequest extends FormRequest
{
  /**
   * Determina si el usuario está autorizado para realizar esta request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Reglas de validación para el inicio de sesión.
   *
   * - email: obligatorio, texto válido con formato de correo
   * - password: obligatorio, texto (sin límite de longitud)
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'email' => ['required', 'string', 'email'],
      'password' => ['required', 'string'],
    ];
  }

  /**
   * Intenta autenticar las credenciales proporcionadas.
   *
   * Verifica que el request no esté rate limited antes de
   * intentar la autenticación. Si las credenciales son inválidas,
   * incrementa el contador de intentos fallidos.
   *
   * @throws ValidationException Si las credenciales son inválidas o está bloqueado
   */
  public function authenticate(): void
  {
    $this->ensureIsNotRateLimited();

    if (
      !Auth::attempt(
        $this->only('email', 'password'),
        $this->boolean('remember'),
      )
    ) {
      RateLimiter::hit($this->throttleKey());

      throw ValidationException::withMessages([
        'email' => trans('auth.failed'),
      ]);
    }

    RateLimiter::clear($this->throttleKey());
  }

  /**
   * Asegura que el request no esté limitado por tasa.
   *
   * Verifica si el usuario ha superado el límite de intentos
   * de login (5 intentos). Si es así, lanza una excepción con
   * el tiempo de espera restante.
   *
   * @throws ValidationException Si se excedió el límite de intentos
   */
  public function ensureIsNotRateLimited(): void
  {
    if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
      return;
    }

    event(new Lockout($this));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
      'email' => trans('auth.throttle', [
        'seconds' => $seconds,
        'minutes' => ceil($seconds / 60),
      ]),
    ]);
  }

  /**
   * Obtiene la clave de rate limiting para el request.
   *
   * Combina el email (en minúsculas) con la IP del cliente
   * para crear una clave única de limitación.
   *
   * @return string Clave única para tracking de intentos
   */
  public function throttleKey(): string
  {
    return Str::transliterate(
      Str::lower($this->string('email')) . '|' . $this->ip(),
    );
  }
}
