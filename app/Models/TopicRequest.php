<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicRequest extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'suggestion'];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
