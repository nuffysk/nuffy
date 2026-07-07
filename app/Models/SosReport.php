<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class SosReport extends Model
{
    use AsSource, Filterable;

    protected $fillable = ['reporter_id', 'city', 'description', 'photo_url', 'contact', 'phone', 'instagram', 'status', 'kind'];

    /** Orchid admin: sortable / filterable columns. */
    protected $allowedSorts = ['id', 'kind', 'status', 'city', 'created_at'];

    protected $allowedFilters = [
        'kind' => Where::class,
        'status' => Where::class,
        'city' => Like::class,
    ];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
