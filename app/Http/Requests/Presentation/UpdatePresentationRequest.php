<?php

namespace App\Http\Requests\Presentation;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresentationRequest extends FormRequest
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
    return [
      'title' => ['required', 'string', 'max:255', 'min:5'],
      'summary' => ['required', 'string', 'max:450', 'min:5'],
      'category' => ['nullable', 'numeric', 'exists:categories,id'],
      'file' => [
        'nullable',
        'file',
        'mimes:pdf,ppt,pptx,key,odp',
        'max:1048000',
      ],
    ];
  }
}
