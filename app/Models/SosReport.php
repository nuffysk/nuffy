<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class SosReport extends Model
{
    use AsSource;

    protected $fillable = ['reporter_id', 'city', 'description', 'photo_url', 'contact', 'phone', 'instagram', 'status', 'kind'];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
