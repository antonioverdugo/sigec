<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sponsor;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo TypeSponsor
 *
 * Representa un tipo de patrocinador en el sistema.
 * Permite categorizar los patrocinadores según su nivel o categoría.
 *
 * @property int $id
 * @property string $name Nombre del tipo de patrocinador
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @see Sponsor
 */
class TypeSponsor extends Model
{
  /**
   * Atributos que pueden ser asignados masivamente.
   *
   * @var array<string>
   */
  protected $fillable = ['name'];

  /**
   * Obtiene los patrocinadores de este tipo.
   *
   * @return HasMany Relación uno a muchos con Sponsor
   * @see Sponsor
   */
  public function sponsors(): HasMany
  {
    return $this->hasMany(Sponsor::class);
  }
}
