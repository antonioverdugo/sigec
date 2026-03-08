<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sponsor;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeSponsor extends Model
{
  // Campos rellenables
  protected $fillable = ['name'];

  // Relacion entre TypeSponsor y Sponsor
  public function sponsors(): HasMany
  {
    return $this->hasMany(Sponsor::class);
  }
}
