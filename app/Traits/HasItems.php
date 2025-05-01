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
        $items = is_array($this->items) ? $this->items : [];

        $found = false;

        foreach ($items as &$item) {
            if ($item['id'] == $itemId) {
                $item['stack'] += $stack;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $items[] = ['id' => $itemId, 'stack' => $stack];
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
