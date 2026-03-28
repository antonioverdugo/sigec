<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;
use App\Models\TypePresentation;
use App\Models\User;

/**
 * Modelo Presentation
 *
 * Representa una presentación académica en el sistema.
 *
 * @property int $id
 * @property string $title Título de la presentación
 * @property string|null $summary Resumen o abstract
 * @property string|null $url_file Ruta al archivo de la presentación
 * @property int $type_presentation_id FK al tipo de presentación
 * @property string|null $type_file Tipo de archivo (pdf, pptx, etc.)
 * @property int $user_id FK al autor
 * @property int $category_id FK a la categoría
 * @property bool $published Indica si está publicada
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @see TypePresentation
 * @see User
 * @see Category
 */
class Presentation extends Model
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
    'type_file',
    'user_id',
    'category_id',
    'published',
  ];

  /**
   * Obtiene el tipo de presentación asociado.
   *
   * @return BelongsTo Relación de pertenencia con TypePresentation
   * @see TypePresentation
   */
  public function type_presentation(): BelongsTo
  {
    return $this->belongsTo(TypePresentation::class);
  }

  /**
   * Obtiene el usuario autor de la presentación.
   *
   * @return BelongsTo Relación de pertenencia con User
   * @see User
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Obtiene la categoría asociada a la presentación.
   *
   * @return BelongsTo Relación de pertenencia con Category
   * @see Category
   */
  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }
}
