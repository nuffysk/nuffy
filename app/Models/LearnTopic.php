<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class LearnTopic extends Model
{
    use AsSource;

    protected $fillable = ['slug', 'title', 'summary', 'body', 'video_url', 'thumbnail_url', 'photos', 'sort_order'];

    protected $casts = [
        'photos' => 'array',
        'sort_order' => 'integer',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(LearnComment::class, 'topic_id');
    }

    public function likers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'learn_likes', 'topic_id', 'user_id')->withTimestamps();
    }

}
