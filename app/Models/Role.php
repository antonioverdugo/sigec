<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
  // Rellenar el atributo name
  protected $fillable = ['name'];

  // Relacion con la clase User
  public function users(): HasMany
  {
    return $this->hasMany(User::class);
  }
}
