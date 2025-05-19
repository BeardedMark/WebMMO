<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

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
        'properties' => 'array',
        'modifiers' => 'array',
    ];

    // Content

    public function getTitle(): string
    {
        return "{$this->name}";
    }

    public function getImageUrl(): string
    {
        return asset('storage/img/items/' . $this->image);
    }

    // Values

    public function getClass(): string
    {
        return $this->class;
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

    public function getMaxStack(): int
    {
        return $this->max_stack;
    }

    public function getMaxModifiers(): int
    {
        return $this->max_modifiers;
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

    public function getPropertiesArray(): array
    {
        return $this->properties ?? [];
    }

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
        if (empty($this->modifiers)) {
            return collect();
        }

        return Modifier::whereIn('code', $this->modifiers)->get();
    }



    // Functions

    public function droppedByEnemies()
    {
        return Enemy::all()->filter(function ($enemy) {
            if (!$enemy->drop) return false;

            return collect($enemy->drop)->contains($this->id);
        });
    }

    public function generateInstance(int $stack = 1): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'id' => $this->id,
            'stack' => $stack,
            'class' => $this->class,
            'modifiers' => $this->generateModifiers(),
            'properties' => $this->generateProperties(),
            'sockets' => [],
        ];
    }
    public function generateModifiers(): array
    {
        if (!$this->class || empty($this->modifiers)) return [];

        $modifierDefs = Modifier::whereIn('code', $this->modifiers)->get()->shuffle();

        // Чем больше модификаторов — тем реже встречаются
        $weights = [
            0 => 50,  // 50% что не будет модов вообще
            1 => 30,
            2 => 15,
            3 => 8,
            4 => 5,
            5 => 2,
            6 => 1,
        ];

        $max = min(count($modifierDefs), 6);
        $pool = collect();

        foreach ($weights as $amount => $chance) {
            if ($amount <= $max) {
                $pool = $pool->concat(array_fill(0, $chance, $amount));
            }
        }

        $count = $pool->random();

        $selected = $modifierDefs->take($count);

        $result = [];

        foreach ($selected as $mod) {
            $base = $mod->value ?? 1;
            $spread = $mod->spread ?? 0;

            $min = (int) floor($base - ($base * $spread / 100));
            $max = (int) ceil($base + ($base * $spread / 100));

            $result[] = [
                'code' => $mod->code,
                'name' => $mod->name,
                'value' => rand(max(1, $min), max(1, $max)),
            ];
        }

        return $result;
    }


    protected function generateProperties(): array
    {
        if (empty($this->properties) || !is_array($this->properties)) {
            return [];
        }

        $codes = collect($this->properties)->pluck('code')->all();
        $defs = Modifier::whereIn('code', $codes)->get()->keyBy('code');

        $result = [];

        foreach ($this->properties as $property) {
            $code = $property['code'] ?? null;
            if (!$code || !isset($defs[$code])) continue;

            $def = $defs[$code];
            $base = $property['value'] ?? $def->value;
            $spread = $def->spread ?? 0;

            $min = (int) floor($base - ($base * $spread / 100));
            $max = (int) ceil($base + ($base * $spread / 100));

            $result[] = [
                'code' => $def->code,
                'name' => $def->name,
                'value' => rand(max(1, $min), max(1, $max)),
            ];
        }

        return $result;
    }



    public static function generateItemsFromPool(int $count, Collection $items, float $chance = 0): array
    {
        $result = [];

        $weighted = collect();
        foreach ($items as $item) {
            $dropChance = $item->drop_chance + $item->drop_chance * ($chance / 100);
            if ($dropChance > 0) {
                $weighted = $weighted->concat(array_fill(0, max(1, (int) round($dropChance)), $item));
            }
        }

        if ($weighted->isEmpty()) return [];

        $remaining = $count;

        while ($remaining > 0) {
            $picked = $weighted->random();
            $stack = rand(1, min($picked->max_stack, $remaining));
            $instance = $picked->generateInstance($stack);
            $result[] = $instance;
            $remaining -= $stack;
        }

        return $result;
    }
}
