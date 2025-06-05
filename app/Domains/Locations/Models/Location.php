<?php

namespace App\Domains\Locations\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasMetaFields;
use App\Domains\Locations\Traits\HasTransitions;
use App\Domains\Locations\Traits\HasCharacters;
use App\Domains\Locations\Traits\HasRoads;
use App\Domains\Locations\Traits\HasBattles;
use App\Domains\Locations\Traits\HasLocations;
use App\Domains\Items\Models\Item;
use App\Domains\Enemies\Models\Enemy;

class Location extends Model
{
    use SoftDeletes;
    use HasMetaFields;
    use HasCharacters;
    use HasTransitions;
    use HasRoads;
    use HasLocations;
    use HasBattles;

    private $imagesDirectory = 'storage/images/locations/';
    private $soundsDirectory = 'storage/sounds/locations/';

    protected $fillable = [];

    protected $casts = [
        'modifiers' => 'array',
        'requirements' => 'array',
    ];

    public function getTitle(): string
    {
        return $this->getName();
    }

    // Values

    public function getStatus(): bool
    {
        return $this->is_open;
    }

    public function isPeaceful(): bool
    {
        return $this->is_peaceful;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getSize(): int
    {
        return 5 + $this->level + $this->size;
    }

    public function getCordX(): int
    {
        return $this->x;
    }

    public function getCordY(): int
    {
        return $this->y;
    }

    // Loot

    public function availableItems()
    {
        return Item::all();
    }

    public function availableContainers()
    {
        // return Container::all();
    }

    public function availableEnemies()
    {
        return Enemy::all();
    }
}
