<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    protected $fillable = ['code', 'name', 'classes', 'value', 'spread', 'tags'];

    protected $casts = [
        'classes' => 'array',
        'tags' => 'array',
    ];
}
