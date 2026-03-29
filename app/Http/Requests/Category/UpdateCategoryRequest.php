<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para actualizar una categoría.
 *
 * Valida los datos de entrada al modificar una categoría
 * existente en el sistema, verificando nombre y descripción.
 *
 * @package App\Http\Requests\Category
 *
 * @property string $name Nombre de la categoría
 * @property string $description Descripción de la categoría
 */
class UpdateCategoryRequest extends FormRequest
{
  /**
   * Determina si el usuario está autorizado para realizar esta request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Reglas de validación para actualizar una categoría.
   *
   * - name: obligatorio, texto, entre 3 y 200 caracteres
   * - description: obligatorio, texto, mínimo 3 caracteres
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      // Validar los datos para actualizar una categoria
      'name' => 'required|string|min:3|max:200',
      'description' => 'required|string|min:3',
    ];
  }
}
