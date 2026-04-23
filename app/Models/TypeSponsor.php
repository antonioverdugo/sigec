<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeSponsor extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function sponsors(): HasMany
    {
        return $this->hasMany(Sponsor::class);
    }
}