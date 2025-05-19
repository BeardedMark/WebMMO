<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasItems;
use App\Traits\HasEnemies;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Transition extends Model
{
    use SoftDeletes;
    use HasItems;
    use HasEnemies;

    protected $fillable = [
        'character_id',
        'location_id',
        'hideout_id',
        'items',
        'enemies',
    ];

    protected $casts = [
        'items' => 'array',
        'enemies' => 'array',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function hideout()
    {
        return $this->belongsTo(Hideout::class, 'hideout_id');
    }
}
