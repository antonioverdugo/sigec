<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Presentation;
use App\Models\Poster;

/**
 * Modelo TypePresentation
 *
 * Representa un tipo de presentación en el sistema.
 * Permite clasificar presentaciones y pósters según su formato.
 *
 * @property int $id
 * @property string $name Nombre del tipo
 * @property string|null $description Descripción del tipo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @see Presentation
 * @see Poster
 */
class TypePresentation extends Model
{
  /**
   * Atributos que pueden ser asignados masivamente.
   *
   * @var array<string>
   */
  protected $fillable = ['name', 'description'];

  /**
   * Obtiene las presentaciones de este tipo.
   *
   * @return HasMany Relación uno a muchos con Presentation
   * @see Presentation
   */
  public function presentations(): HasMany
  {
    return $this->hasMany(Presentation::class);
  }

  /**
   * Obtiene los pósters de este tipo.
   *
   * @return HasMany Relación uno a muchos con Poster
   * @see Poster
   */
  public function posters(): HasMany
  {
    return $this->hasMany(Poster::class);
  }
}
