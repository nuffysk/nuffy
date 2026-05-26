<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpReport extends Model
{
    protected $fillable = ['reporter_id', 'description', 'city', 'contact', 'photo_url', 'need', 'status'];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
