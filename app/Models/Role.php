<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Role
 *
 * Representa un rol de usuario en el sistema.
 *
 * @property int $id
 * @property string $name Nombre del rol
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @see User
 */
class Role extends Model
{
  /**
   * Atributos que pueden ser asignados masivamente.
   *
   * @var array<string>
   */
  protected $fillable = ['name'];

  /**
   * Obtiene los usuarios que pertenecen a este rol.
   *
   * @return HasMany Relación uno a muchos con User
   * @see User
   */
  public function users(): HasMany
  {
    return $this->hasMany(User::class);
  }
}
