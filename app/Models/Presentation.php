<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;
use App\Models\TypePresentation;
use App\Models\User;

class Presentation extends Model
{
  // Atributos rellenables
  protected $fillable = [
    'title',
    'summary',
    'url_file',
    'type_presentation_id',
    'type_file',
    'user_id',
    'category_id',
    'published',
  ];

  // Relaciones con la tabla type_presentions
  public function type_presentation(): BelongsTo
  {
    return $this->belongsTo(TypePresentation::class);
  }

  // Relacion con la tabla users
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  // Relacion con la tabla categories
  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }
}
