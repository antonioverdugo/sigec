<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\TypePresentation;
use App\Models\User;
use App\Models\Category;

/**
 * Modelo Poster
 *
 * Representa un póster académico en el sistema.
 *
 * @property int $id
 * @property string $title Título del póster
 * @property string|null $summary Resumen o abstract del póster
 * @property string|null $url_file Ruta al archivo PDF del póster
 * @property int $type_presentation_id FK al tipo de presentación
 * @property int $user_id FK al autor del póster
 * @property int $category_id FK a la categoría
 * @property bool $published Indica si está publicado
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @see TypePresentation
 * @see User
 * @see Category
 */
class Poster extends Model
{
  /**
   * Atributos que pueden ser asignados masivamente.
   *
   * @var array<string>
   */
  protected $fillable = [
    'title',
    'summary',
    'url_file',
    'type_presentation_id',
    'user_id',
    'category_id',
    'published',
  ];

  /**
   * Obtiene el tipo de presentación asociado al póster.
   *
   * @return BelongsTo Relación de pertenencia con TypePresentation
   * @see TypePresentation
   */
  public function type_presentation(): BelongsTo
  {
    return $this->belongsTo(TypePresentation::class);
  }

  /**
   * Obtiene el usuario autor del póster.
   *
   * @return BelongsTo Relación de pertenencia con User
   * @see User
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Obtiene la categoría asociada al póster.
   *
   * @return BelongsTo Relación de pertenencia con Category
   * @see Category
   */
  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }
}
