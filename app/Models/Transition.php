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
        // 'from_location_id',
        // 'to_location_id',
        'location_id',
        'hideout_id',
        // 'next_action_at',
        'items',
        'enemies',
    ];

    protected $casts = [
        'next_action_at' => 'datetime',
        'items' => 'array',
        'enemies' => 'array',
    ];

    public function getTitle()
    {
        $character = $this->character?->name;
        $fromLocation = $this->fromLocation?->name;
        $toLocation = $this->toLocation?->name;

        return "[{$character}] {$fromLocation} > {$toLocation}";
    }

    public function getDistance()
    {
        $fromLocation = $this->fromLocation;
        $toLocation = $this->toLocation;

        // Получаем координаты обеих локаций
        $x1 = $fromLocation->x;
        $y1 = $fromLocation->y;
        $x2 = $toLocation->x;
        $y2 = $toLocation->y;

        // Вычисляем расстояние по формуле
        $distance = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));

        return $distance;
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'location_id');
        // return $this->belongsTo(Location::class, 'to_location_id');
    }

    public function hideout()
    {
        return $this->belongsTo(Hideout::class, 'hideout_id');
    }
}
