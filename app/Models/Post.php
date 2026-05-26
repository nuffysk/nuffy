<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = ['author_id', 'dog_id', 'image_url', 'caption'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::class);
    }
}
