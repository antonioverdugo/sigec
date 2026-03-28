<?php

namespace App\Models;

use App\Models\TypeSponsor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Sponsor
 *
 * Representa un patrocinador en el sistema.
 *
 * @property int $id
 * @property string $name Nombre del patrocinador
 * @property string $email Correo electrónico
 * @property string|null $phone Teléfono de contacto
 * @property float|null $amount_contributed Monto contribuido
 * @property int $type_sponsor_id FK al tipo de patrocinador
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @see TypeSponsor
 */
class Sponsor extends Model
{
  /**
   * Atributos que pueden ser asignados masivamente.
   *
   * @var array<string>
   */
  protected $fillable = [
    'name',
    'email',
    'phone',
    'amount_contributed',
    'type_sponsor_id',
  ];

  /**
   * Obtiene el tipo de patrocinador asociado.
   *
   * @return BelongsTo Relación de pertenencia con TypeSponsor
   * @see TypeSponsor
   */
  public function type_sponsor(): BelongsTo
  {
    return $this->belongsTo(TypeSponsor::class);
  }
}
