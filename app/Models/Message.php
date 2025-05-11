<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'message', 'user_id', 'character_id', 'location_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
