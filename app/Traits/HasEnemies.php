<?php

namespace App\Traits;

use App\Models\Enemy;
use Illuminate\Support\Collection;

trait HasEnemies
{
    public function enemies(): Collection
    {
        $enemiesData = collect($this->enemies);
        $enemies = Enemy::whereIn('id', $enemiesData->pluck('id'))->get()->keyBy('id');

        return $enemiesData->map(function ($enemyData) use ($enemies) {
            $enemy = $enemies->get($enemyData['id']);

            if (!$enemy) {
                return null;
            }

            return (object)[
                'enemy' => $enemy,
                'stack' => $enemyData['stack'] ?? 1,
            ];
        })->filter()->sortBy(function ($entry) {
            return $entry->enemy->getSpawnChance();
        })->values();
    }

    public function getTotalEnemiesdanger(): float
    {
        return $this->getEnemies()->sum(function ($item) {
            return $item->item->getWeight()* $item->stack;
        });
    }

    public function getTotalEnemiesCount(): int
    {
        return $this->getEnemies()->sum('stack');
    }

    public function getEnemiesCount(): int
    {
        return count($this->getEnemies());
    }

    // public function addItem($itemId, int $stack = 1): void
    // {
    //     $items = is_array($this->items) ? $this->items : [];

    //     $found = false;

    //     foreach ($items as &$item) {
    //         if ($item['id'] == $itemId) {
    //             $item['stack'] += $stack;
    //             $found = true;
    //             break;
    //         }
    //     }

    //     if (!$found) {
    //         $items[] = ['id' => $itemId, 'stack' => $stack];
    //     }

    //     $this->items = $items;
    //     $this->save();
    // }


    public function removeEnemy($enemyId, int $stack = 1): void
    {
        $enemies = is_array($this->enemies) ? $this->enemies : [];

        foreach ($enemies as $key => &$enemy) {
            if ($enemy['id'] == $enemyId) {
                $enemy['stack'] -= $stack;

                if ($enemy['stack'] <= 0) {
                    unset($enemies[$key]);
                }

                break;
            }
        }

        $this->enemies = array_values($enemies); // пересобираем индексы
        $this->save();
    }


    // public function moveItemTo($itemId, $target, int $stack = 1): void
    // {
    //     $this->removeItem($itemId, $stack);
    //     $target->addItem($itemId, $stack);
    // }

    // public function swapInventoryWith($target): void
    // {
    //     $currentItems = $this->items;
    //     $targetItems = $target->items;

    //     $this->items = $targetItems;
    //     $this->save();

    //     $target->items = $currentItems;
    //     $target->save();
    // }

    // public function moveAllItemsTo($target): void
    // {
    //     $items = is_array($this->items) ? $this->items : [];

    //     foreach ($items as $item) {
    //         $target->addItem($item['id'], $item['stack']);
    //     }

    //     $this->items = [];
    //     $this->save();
    // }
}
