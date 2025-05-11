<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Item extends Model
{
    use SoftDeletes;

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
    ];

    // Values

    public function getTitle()
    {
        return "{$this->name}";
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getMaxStack()
    {
        return $this->max_stack;
    }

    public function getDropChance()
    {
        return $this->drop_chance;
    }

    public function getMinLevel()
    {
        return $this->min_level ?? "–";
    }

    public function getMaxLevel()
    {
        return $this->max_level ?? "–";
    }

    public function getWeightTitle()
    {
        return "{$this->weight} кг";
    }

    public function getImageUrl()
    {
        return asset('storage/img/items/' . $this->image);
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
    public function getCraftItems()
    {
        if (empty($this->craft)) {
            return collect();
        }

        $itemIds = collect($this->craft)->pluck('item')->toArray();
        $items = self::whereIn('id', $itemIds)->get()->keyBy('id');

        return collect($this->craft)->map(function ($craftItem) use ($items) {
            $item = $items->get($craftItem['item']);
            return (object)[
                'item' => $item,
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

            return collect($item->craft)->pluck('item')->contains($this->id);
        });
    }

    public function droppedByEnemies()
    {
        return Enemy::all()->filter(function ($enemy) {
            if (!$enemy->drop) return false;

            return collect($enemy->drop)->contains($this->id);
        });
    }

    public static function generateItem($item, int $remaining, int $chanceScale = 0): array
    {
        $generated = [];
        $stack = 0;
        $maxStack = $item->max_stack ?? PHP_INT_MAX;
        $dropChance = $item->drop_chance + $item->drop_chance * ($chanceScale / 100);

        for ($i = 0; $i <= $remaining; $i++) {
            if (mt_rand(1, 100) <= $dropChance) {
                $stack++;

                if ($stack >= $remaining) break;
            }
        }

        // Разбиваем на пачки
        while ($stack > 0) {
            $addStack = min($stack, $maxStack);
            $generated[] = [
                'uuid' => (string) Str::uuid(),
                'id' => $item->id,
                'stack' => $addStack,
            ];
            $stack -= $addStack;
        }

        return $generated;
    }


    public static function generateItems($totalCount, $availableItems, $chanceScale = 0): array
    {
        $items = [];
        $maxTotal = mt_rand(0, $totalCount);
        $totalAdded = 0;

        if ($maxTotal > 0) {
            foreach ($availableItems as $item) {
                $remaining = $maxTotal - $totalAdded;
                if ($remaining <= 0) break;

                $generated = self::generateItem($item, $remaining, $chanceScale);
                $totalAdded += collect($generated)->sum('stack');

                $items = array_merge($items, $generated);

                if ($totalAdded >= $maxTotal) break;
            }
        }

        return $items;
    }
}
