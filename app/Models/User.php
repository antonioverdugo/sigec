<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = ['name', 'email', 'password', 'role_id'];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = ['password', 'remember_token'];

  /**
   * Get the attributes that should be cast.
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
   * Añade la relacion con la tabla roles
   */
  public function role(): BelongsTo
  {
    return $this->belongsTo(Role::class);
  }

  // Devolver las iniciales del usuario
  // En app/Models/User.php
  public function getInitialsAttribute(): string
  {
    return collect(explode(' ', $this->name))
      ->map(fn($w) => Str::substr($w, 0, 1))
      ->take(2)
      ->implode('');
  }
}
