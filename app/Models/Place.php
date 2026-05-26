<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Place extends Model
{
    use AsSource;

    protected $fillable = ['name', 'category', 'city', 'address', 'description', 'image_url'];
}
