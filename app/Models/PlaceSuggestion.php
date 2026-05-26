<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceSuggestion extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'category', 'name', 'city', 'note'];

    protected $casts = ['created_at' => 'datetime'];
}
