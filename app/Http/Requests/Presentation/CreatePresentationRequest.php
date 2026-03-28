<?php

namespace App\Http\Requests\Presentation;

use Illuminate\Foundation\Http\FormRequest;

class CreatePresentationRequest extends FormRequest
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
    // Validar los datos
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
      'file' => [
        'required',
        'file',
        'mimes:pdf,ppt,pptx,key,odp',
        'max:1048000',
      ],
    ];
  }
  public function messages(): array
  {
    return [
      'title.regex' =>
        'El título contiene caracteres no permitidos para nombres de archivo (no usar: / \ : * ? " < > |).',
    ];
  }
}
