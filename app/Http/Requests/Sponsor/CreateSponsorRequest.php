<?php

namespace App\Http\Requests\Sponsor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request para crear un patrocinador.
 *
 * Valida los datos de entrada al registrar un nuevo patrocinador
 * en el sistema, incluyendo nombre, correo, teléfono, monto de contribución y tipo.
 *
 * @package App\Http\Requests\Sponsor
 *
 * @property string $name Nombre del patrocinador
 * @property string $email Correo electrónico del patrocinador
 * @property string|null $phone Número de teléfono (opcional, 9 dígitos)
 * @property float $amount_contributed Monto contribuido
 * @property int $type_sponsor_id ID del tipo de patrocinador
 */
class CreateSponsorRequest extends FormRequest
{
  /**
   * Determina si el usuario está autorizado para realizar esta request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Reglas de validación para crear un patrocinador.
   *
   * - name: obligatorio, texto, entre 3 y 200 caracteres
   * - email: obligatorio, formato válido de correo, único en sponsors
   * - phone: opcional, 9 dígitos, debe iniciar en 6, 8 o 9
   * - amount_contributed: obligatorio, numérico, entre 0 y 9999999999999.99
   * - type_sponsor_id: obligatorio, debe existir en la tabla type_sponsors
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    $sponsorId = $this->sponsor?->id;
    return [
      // Validar los datos para crear un usuario
      'name' => 'required|string|min:3|max:200',
      'email' => [
        'required',
        'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        'unique:sponsors,email,' . $sponsorId,
        'max:200',
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
