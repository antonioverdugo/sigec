<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Presentation;
use App\Models\Poster;

/**
 * Modelo Category
 *
 * Representa una categoría en el sistema que permite clasificar
 * presentaciones y pósters.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @see Presentation
 * @see Poster
 */

class Category extends Model
{
  /**
   * Atributos que pueden ser asignados masivamente.
   *
   * @var array<string>
   */
  protected $fillable = ['name', 'description'];

  /**
   * Obtiene las presentaciones asociadas a esta categoría.
   *
   * @return HasMany Relación uno a muchos con Presentation
   * @see Presentation
   */
  public function presentations(): HasMany
  {
    return $this->hasMany(Presentation::class);
  }

  /**
   * Obtiene los pósters asociados a esta categoría.
   *
   * @return HasMany Relación uno a muchos con Poster
   * @see Poster
   */
  public function posters(): HasMany
  {
    return $this->hasMany(Poster::class);
  }
}
