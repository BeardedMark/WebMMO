<?php

namespace App\Domains\Items\Models;

use App\Domains\Modifiers\Models\Modifier;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Locations\Models\Location;
use App\Domains\Enemies\Models\Enemy;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use App\Traits\HasMetaFields;

class Item extends Model
{
    use SoftDeletes;
    use HasMetaFields;

    protected $fillable = [
        'name',
        'image',
        'weight',
        'drop_chance',
        'min_level',
        'max_level',
        'tags'
    ];

    protected $casts = [
        'craft' => 'array',
        'tags' => 'array',
        'modifiers' => 'array',
        'requirements' => 'array',
    ];

    // Content

    public function getTitle(): string
    {
        return "{$this->name}";
    }

    public function getImageUrl(): string
    {
        return asset('storage/images/items/' . $this->image);
    }

    // Values

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDropChance(): float
    {
        return $this->drop_chance;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getWeightTitle(): string
    {
        return "{$this->weight} кг";
    }

    public function getMinLevel(): ?int
    {
        return $this->min_level;
    }

    public function getMaxLevel(): ?int
    {
        return $this->max_level;
    }

    // Arrays

    public function getModifiersArray(): array
    {
        return $this->modifiers ?? [];
    }

    public function getCraftArray(): array
    {
        return $this->craft ?? [];
    }

    // Dependencies

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

    public function getCraftItems()
    {
        if (empty($this->craft)) {
            return collect();
        }

        $itemCodes = collect($this->craft)->pluck('code')->toArray();
        $items = self::whereIn('code', $itemCodes)->get()->keyBy('code');

        return collect($this->craft)->map(function ($craftItem) use ($items) {
            $item = $items->get($craftItem['code']);
            return (object)[
                'item' => $item,
                'code' => $craftItem['code'],
                'stack' => $craftItem['stack'],
            ];
        })->filter(function ($craft) {
            return $craft->item !== null;
        });
    }

    public function usedInCrafts()
    {
        return self::all()->filter(function ($item) {
            if (!$item->craft) return false;

            return collect($item->craft)->pluck('code')->contains($this->code);
        });
    }

    public function getAvailableProperties(): Collection
    {
        if (empty($this->properties)) {
            return collect();
        }

        $codes = collect($this->properties)->pluck('code')->unique()->all();

        return Modifier::whereIn('code', $codes)->get();
    }

    public function getAvailableModifiers(): Collection
    {
        if (empty($this->getModifiersArray())) {
            return collect();
        }
        $codes = collect($this->getModifiersArray())->pluck('code')->unique()->all();

        return Modifier::whereIn('code', $codes)->get();
    }

    public function droppedByEnemies()
    {
        return Enemy::all()->filter(function ($enemy) {
            if (!$enemy->drop) return false;

            return collect($enemy->drop)->contains($this->code);
        });
    }
}
