<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poster extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'url_file',
        'type_presentation_id',
        'user_id',
        'category_id',
        'published',
    ];

    public function type_presentation(): BelongsTo
    {
        return $this->belongsTo(TypePresentation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}