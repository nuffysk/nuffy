<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dog extends Model
{
    protected $fillable = [
        'owner_id', 'name', 'breed', 'age_years', 'birth_year', 'birth_date',
        'personality', 'photo_url', 'size', 'gender', 'health_notes',
        'vaccinated', 'photos', 'neutered', 'microchipped', 'vaccinations', 'vet',
    ];

    protected $casts = [
        'age_years' => 'decimal:1',
        'birth_year' => 'integer',
        'birth_date' => 'date',
        'vaccinated' => 'boolean',
        'neutered' => 'boolean',
        'microchipped' => 'boolean',
        'photos' => 'array',
        'vaccinations' => 'array',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
