<?php

namespace App\Domains\Modifiers\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMetaFields;

class Modifier extends Model
{
    use HasMetaFields;

    protected $fillable = [
        'code',
        'name',
        'value',
        'spread',
        'tags'
    ];

    protected $casts = [
        'value' => 'float',
        'spread' => 'float',
        'tags' => 'array',
    ];
}
