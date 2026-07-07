<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class DeletionLog extends Model
{
    use AsSource;

    protected $fillable = [
        'user_id',
        'email',
        'name',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}
