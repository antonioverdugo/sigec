<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request para actualizar el perfil del usuario autenticado.
 *
 * Valida los datos de entrada al modificar el perfil del usuario
 * actualmente autenticado, incluyendo nombre y correo electrónico.
 *
 * @package App\Http\Requests
 *
 * @property string $name Nombre del usuario
 * @property string $email Correo electrónico del usuario
 */
class ProfileUpdateRequest extends FormRequest
{
  /**
   * Reglas de validación para actualizar el perfil.
   *
   * - name: obligatorio, texto, máximo 255 caracteres
   * - email: obligatorio, texto en minúsculas, formato válido de correo,
   *          máximo 255 caracteres, único en users (excluye el usuario actual)
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'email' => [
        'required',
        'string',
        'lowercase',
        'email',
        'max:255',
        Rule::unique(User::class)->ignore($this->user()->id),
      ],
    ];
  }
}
