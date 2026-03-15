<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Presentation;

class TypePresentation extends Model
{
  // Atributos rellenales
  protected $fillable = ['name', 'description'];

  // Relacion con la tabla presentations
  public function presentations(): HasMany
  {
    return $this->hasMany(Presentation::class);
  }
}
