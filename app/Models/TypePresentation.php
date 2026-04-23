<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Presentation;
use App\Models\Poster;

class TypePresentation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }

    public function posters(): HasMany
    {
        return $this->hasMany(Poster::class);
    }
}