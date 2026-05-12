<?php

namespace App\Http\Requests\Presentation;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para crear una presentación.
 *
 * Valida los datos de entrada al registrar una nueva presentación
 * en el sistema, incluyendo título, resumen, categoría y archivo multimedia.
 *
 *
 * @property string $title Título de la presentación
 * @property string $summary Resumen o abstract de la presentación
 * @property int|null $category ID de la categoría (opcional)
 * @property \Illuminate\Http\File $file Archivo de presentación (PDF, PPT, PPTX, KEY, ODP)
 */
class CreatePresentationRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear una presentación.
     *
     * - title: obligatorio, texto, entre 5 y 200 caracteres, sin caracteres especiales
     * - summary: obligatorio, texto, entre 5 y 350 caracteres
     * - category: opcional, numérico, debe existir en la tabla categories
     * - file: obligatorio, archivo (PDF, PPT, PPTX, KEY, ODP), máximo 1MB
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Validar los datos
        return [
            'title' => [
                'required',
                'string',
                'max:200',
                'min:5',
                'regex:/^[^\/\\:*?"<>|\x00]+$/',
                'unique:presentations,title',
            ],
            'summary' => ['required', 'string', 'max:350', 'min:5'],
            'category' => ['nullable', 'numeric', 'exists:categories,id'],
            'file' => [
                'required',
                'file',
                'mimes:pdf,ppt,pptx,key,odp',
                'max:1048000',
            ],
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
