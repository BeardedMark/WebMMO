<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Domains\Items\Traits\HasItems;
// use App\Traits\HasContainers;
use App\Domains\Enemies\Traits\HasEnemies;
use App\Domains\Modifiers\Traits\HasModifiers;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\Locations\Models\Location;
use App\Domains\Characters\Models\Character;

class Transition extends Model
{
    use SoftDeletes;
    use HasItems;
    use HasEnemies;
    // use HasContainers;
    use HasModifiers;

    protected $fillable = [
        'character_id',
        'location_id',
        'inventory',
        'enemies',
        'containers',
    ];

    protected $casts = [
        'inventory' => 'array',
        'enemies' => 'array',
        'containers' => 'array',
        'modifiers' => 'array',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
