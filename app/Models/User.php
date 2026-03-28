<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\Presentation;
use App\Models\Poster;
use App\Models\Role;

/**
 * Modelo User
 *
 * Representa un usuario del sistema con autenticación.
 *
 * @property int $id
 * @property string $name Nombre completo
 * @property string $email Correo electrónico único
 * @property string $password Contraseña hasheada
 * @property int $role_id FK al rol del usuario
 * @property \Carbon\Carbon|null $email_verified_at Fecha de verificación del email
 * @property string|null $remember_token Token para recordar sesión
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read Role $role
 * @property-read string $initials Iniciales del nombre
 *
 * @see Role
 * @see Presentation
 * @see Poster
 */
class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * Atributos que pueden ser asignados masivamente.
   *
   * @var list<string>
   */
  protected $fillable = ['name', 'email', 'password', 'role_id'];

  /**
   * Atributos ocultos al serializar el modelo.
   *
   * @var list<string>
   */
  protected $hidden = ['password', 'remember_token'];

  /**
   * Define los casts de atributos.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  /**
   * Obtiene las iniciales del nombre del usuario.
   *
   * Toma las primeras letras de las palabras del nombre,
   * máximo 2 caracteres.
   *
   * @return string Iniciales en mayúsculas (ej: "JD" para "Juan Pérez")
   */
  public function role(): BelongsTo
  {
    return $this->belongsTo(Role::class);
  }

  /**
   * Obtiene las presentaciones creadas por el usuario.
   *
   * @return HasMany Relación uno a muchos con Presentation
   * @see Presentation
   */
  public function presentations(): HasMany
  {
    return $this->hasMany(Presentation::class);
  }

  /**
   * Obtiene los pósters creados por el usuario.
   *
   * @return HasMany Relación uno a muchos con Poster
   * @see Poster
   */
  public function posters(): HasMany
  {
    return $this->hasMany(Poster::class);
  }

  /**
   * Obtiene las iniciales del nombre del usuario.
   *
   * Toma las primeras letras de las palabras del nombre,
   * máximo 2 caracteres.
   *
   * @return string Iniciales en mayúsculas (ej: "JD" para "Juan Pérez")
   */
  public function getInitialsAttribute(): string
  {
    return collect(explode(' ', $this->name))
      ->map(fn($w) => Str::substr($w, 0, 1))
      ->take(2)
      ->implode('');
  }
}
