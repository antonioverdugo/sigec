<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para crear una categoría.
 *
 * Valida los datos de entrada al registrar una nueva categoría
 * en el sistema, verificando nombre y descripción.
 *
 *
 * @property string $name Nombre de la categoría
 * @property string $description Descripción de la categoría
 */
class CreateCategoryRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear una categoría.
     *
     * - name: obligatorio, texto, entre 3 y 200 caracteres
     * - description: obligatorio, texto, mínimo 3 caracteres
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Validar los datos para crear una categoria
            'name' => 'required|string|min:3|max:200|unique:categories,name|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/',
            'description' => 'required|string|min:3',
        ];
    }
}
