<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasItems;

class Hideout extends Model
{
    use SoftDeletes, HasItems;

    protected $fillable = [
        'user_id',
        'location_id',
        'name',
        'level',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
