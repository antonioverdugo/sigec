<?php

namespace App\Http\Requests\Poster;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para crear un póster.
 *
 * Valida los datos de entrada al registrar un nuevo póster
 * en el sistema, incluyendo título, resumen, categoría y archivo PDF.
 *
 *
 * @property string $title Título del póster
 * @property string $summary Resumen o abstract del póster
 * @property int|null $category ID de la categoría (opcional)
 * @property \Illuminate\Http\File $file Archivo PDF del póster
 */
class CreatePosterRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear un póster.
     *
     * - title: obligatorio, texto, entre 5 y 200 caracteres, sin caracteres especiales
     * - summary: obligatorio, texto, entre 5 y 350 caracteres
     * - category: opcional, numérico, debe existir en la tabla categories
     * - file: obligatorio, archivo PDF, máximo 1MB
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Validar los datos
            'title' => [
                'required',
                'string',
                'max:200',
                'min:5',
                'regex:/^[^\/\\:*?"<>|\x00]+$/',
                'unique:posters,title',
            ],
            'summary' => ['required', 'string', 'max:350', 'min:5'],
            'category' => ['nullable', 'numeric', 'exists:categories,id'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:1048000'],
        ];
    }

    /**
     * Mensajes de error personalizados para cada regla.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.regex' => 'El título contiene caracteres no permitidos para nombres de archivo (no usar: / \ : * ? " < > |).',
        ];
    }
}
