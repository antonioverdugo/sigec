<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  // Atributos rellenables
  protected $fillable = ['name', 'description'];
}
