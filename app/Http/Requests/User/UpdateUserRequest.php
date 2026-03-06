<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    $userId = $this->user?->id;
    return [
      // Validar los datos para actualizar el usuario
      'name' => 'required|string|min:3|max:255',
      'email' => [
        'required',
        'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        'unique:users,email,' . $userId,
      ],
      'password' => 'nullable|string|min:8',
      'role_id' => 'required|exists:roles,id',
    ];
  }
}
