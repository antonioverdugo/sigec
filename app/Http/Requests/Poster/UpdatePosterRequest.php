<?php

namespace App\Http\Requests\Poster;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para actualizar un póster.
 *
 * Valida los datos de entrada al modificar un póster
 * existente en el sistema, incluyendo título, resumen, categoría y archivo PDF.
 *
 * @package App\Http\Requests\Poster
 *
 * @property string $title Título del póster
 * @property string $summary Resumen o abstract del póster
 * @property int|null $category ID de la categoría (opcional)
 * @property \Illuminate\Http\File|null $file Archivo PDF del póster (opcional)
 */
class UpdatePosterRequest extends FormRequest
{
  /**
   * Determina si el usuario está autorizado para realizar esta request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Reglas de validación para actualizar un póster.
   *
   * - title: obligatorio, texto, entre 5 y 200 caracteres, sin caracteres especiales
   * - summary: obligatorio, texto, entre 5 y 350 caracteres
   * - category: opcional, numérico, debe existir en la tabla categories
   * - file: opcional, archivo PDF, máximo 1MB
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'title' => [
        'required',
        'string',
        'max:200',
        'min:5',
        'regex:/^[^\/\\:*?"<>|\x00]+$/',
      ],
      'summary' => ['required', 'string', 'max:350', 'min:5'],
      'category' => ['nullable', 'numeric', 'exists:categories,id'],
      'file' => ['nullable', 'file', 'mimes:pdf', 'max:1048000'],
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
      'title.regex' =>
        'El título contiene caracteres no permitidos para nombres de archivo (no usar: / \ : * ? " < > |).',
    ];
  }
}
