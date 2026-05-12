<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para crear un usuario.
 *
 * Valida los datos de entrada al registrar un nuevo usuario
 * en el sistema, incluyendo nombre, correo, contraseña y rol.
 *
 *
 * @property string $name Nombre del usuario
 * @property string $email Correo electrónico del usuario
 * @property string $password Contraseña del usuario
 * @property int $role_id ID del rol asignado
 */
class CreateUserRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear un usuario.
     *
     * - name: obligatorio, texto, entre 3 y 255 caracteres
     * - email: obligatorio, formato válido de correo, único en users
     * - password: obligatorio, texto, mínimo 8 caracteres
     * - role_id: obligatorio, debe existir en la tabla roles
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user?->id;

        return [
            // Validar los datos para crear un usuario
            'name' => 'required|string|min:3|max:255|unique:users,name|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/',
            'email' => [
                'required',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:users,email,'.$userId,
            ],
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ];
    }
}
