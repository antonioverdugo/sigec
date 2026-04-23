<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sponsor extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'amount_contributed',
        'type_sponsor_id',
    ];

    public function type_sponsor(): BelongsTo
    {
        return $this->belongsTo(TypeSponsor::class);
    }
}