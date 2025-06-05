<?php

namespace App\Domains\Enemies\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\Modifiers\Traits\HasModifiers;
use App\Domains\Locations\Models\Location;
use App\Domains\Items\Models\Item;

use Illuminate\Support\Collection;

class Enemy extends Model
{
    use SoftDeletes;
    use HasModifiers;

    protected $fillable = [
        'name', 'image', 'spawn_chance', 'danger', 'min_level', 'max_level'
    ];

    protected $casts = [
        'drop' => 'array',
        'attributes' => 'array',
        'modifiers' => 'array'
    ];

    public function getTitle()
    {
        return $this->name;
    }

    public function getDanger()
    {
        return $this->danger;
    }

    public function getSpawnChance()
    {
        return $this->spawn_chance;
    }

    public function getMinLevel()
    {
        return $this->min_level;
    }

    public function getMaxLevel()
    {
        return $this->max_level;
    }

    public function getImageUrl()
    {
        return asset('storage/images/enemies/' . $this->image);
    }

    public function getHealth()
    {
        return 10;
    }

    public function getDamage()
    {
        return 1;
    }

    public function getDropList(): array
    {
        return $this->drop ?? [];
    }

    public function availableItems(): Collection
    {
        if (empty($this->drop)) {
            return collect();
        }

        $codes = collect($this->drop)->pluck('code')->unique()->all();

        return Item::whereIn('code', $codes)->get();
    }

    public function availableLocations()
    {
        $query = Location::query();

        if (!is_null($this->min_level)) {
            $query->where('level', '>=', $this->min_level);
        }

        if (!is_null($this->max_level)) {
            $query->where('level', '<=', $this->max_level);
        }

        return $query->orderBy('level')->get();
    }
}
