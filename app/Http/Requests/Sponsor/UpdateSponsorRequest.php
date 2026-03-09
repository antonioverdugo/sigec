<?php

namespace App\Http\Requests\Sponsor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSponsorRequest extends FormRequest
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
    $sponsorId = $this->sponsor?->id;
    return [
      // Validar los datos para crear un usuario
      'name' => 'required|string|min:3|max:255',
      'email' => [
        'required',
        'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        'unique:sponsors,email,' . $sponsorId,
      ],
      'phone' => 'nullable|regex:/^[689]\d{8}$/',
      'amount_contributed' => [
        'required',
        'numeric',
        'min:0',
        'max:9999999999999.99', // 13 dígitos enteros + 2 decimales = 15,2
      ],
      'type_sponsor_id' => 'required|exists:type_sponsors,id',
    ];
  }
}
