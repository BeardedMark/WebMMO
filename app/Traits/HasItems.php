<?php

namespace App\Traits;

use App\Models\Item;
use Illuminate\Support\Collection;

trait HasItems
{
    public function getItems(): Collection
    {
        $itemsData = collect($this->items);

        $items = Item::whereIn('id', $itemsData->pluck('id'))->get()->keyBy('id');

        return $itemsData->map(function ($itemData) use ($items) {
            $item = $items->get($itemData['id']);

            if (!$item) {
                return null;
            }

            return (object)[
                'item' => $item,
                'stack' => $itemData['stack'] ?? 1,
            ];
        })->filter()->sortBy(function ($entry) {
            return $entry->item->getDropChance();
        })->values();
    }

    public function getDisassembleItems(int $level): Collection
    {
        return $this->getItems()->filter(function ($entry) use ($level) {
            $item = $entry->item;
            return !empty($item->craft) && ($item->min_level ?? 0) <= $level;
        })->values();
    }

    public function getCraftableItems(int $level): Collection
    {
        return Item::query()
        ->whereNotNull('craft')
        ->where(function ($query) use ($level) {
            $query->whereNull('min_level')
                  ->orWhere('min_level', '<=', $level);
        })
        ->get();
    }

    public function getAvailableCrafts(int $level): Collection
    {
        $inventory = $this->getItems()->mapWithKeys(function ($entry) {
            return [$entry->item->id => $entry->stack];
        });

        return Item::query()
            ->whereNotNull('craft')
            ->where(function ($query) use ($level) {
                $query->whereNull('min_level')
                      ->orWhere('min_level', '<=', $level);
            })
            ->get()
            ->filter(function ($item) use ($inventory) {
                foreach ($item->craft as $component) {
                    $requiredId = $component['item'];
                    $requiredStack = $component['stack'];

                    if (!isset($inventory[$requiredId]) || $inventory[$requiredId] < $requiredStack) {
                        return false;
                    }
                }
                return true;
            })
            ->values();
    }


    public function getTotalItemsWeight(): float
    {
        return $this->getItems()->sum(function ($item) {
            return $item->item->getWeight() * $item->stack;
        });
    }

    public function getTotalItemsCount(): int
    {
        return $this->getItems()->sum('stack');
    }

    public function getItemsCount(): int
    {
        return count($this->getItems());
    }

    public function addItem($itemId, int $stack = 1): void
    {
        $itemModel = Item::findOrFail($itemId);
        $maxStack = $itemModel->max_stack ?? PHP_INT_MAX;
        $items = is_array($this->items) ? $this->items : [];

        $remainingStack = $stack;
        $added = false;

        // Сначала пробуем заполнить существующие стопки
        foreach ($items as &$item) {
            if ($item['id'] == $itemId && $item['stack'] < $maxStack) {
                $availableSpace = $maxStack - $item['stack'];
                $toAdd = min($availableSpace, $remainingStack);
                $item['stack'] += $toAdd;
                $remainingStack -= $toAdd;

                if ($remainingStack <= 0) {
                    $added = true;
                    break;
                }
            }
        }

        // Если остался нераспределённый остаток — создаём новые стопки
        while ($remainingStack > 0) {
            $toAdd = min($maxStack, $remainingStack);
            $items[] = ['id' => $itemId, 'stack' => $toAdd];
            $remainingStack -= $toAdd;
        }

        $this->items = $items;
        $this->save();
    }


    public function removeItem($itemId, int $stack = 1): void
    {
        $items = is_array($this->items) ? $this->items : [];

        foreach ($items as $key => &$item) {
            if ($item['id'] == $itemId) {
                $item['stack'] -= $stack;

                if ($item['stack'] <= 0) {
                    unset($items[$key]);
                }

                break;
            }
        }

        $this->items = array_values($items); // пересобираем индексы
        $this->save();
    }


    public function moveItemTo($itemId, $target, int $stack = 1): void
    {
        $this->removeItem($itemId, $stack);
        $target->addItem($itemId, $stack);
    }

    public function swapInventoryWith($target): void
    {
        $currentItems = $this->items;
        $targetItems = $target->items;

        $this->items = $targetItems;
        $this->save();

        $target->items = $currentItems;
        $target->save();
    }

    public function moveAllItemsTo($target): void
    {
        $items = is_array($this->items) ? $this->items : [];

        foreach ($items as $item) {
            $target->addItem($item['id'], $item['stack']);
        }

        $this->items = [];
        $this->save();
    }
}
