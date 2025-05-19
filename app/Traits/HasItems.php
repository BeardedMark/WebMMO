<?php

namespace App\Traits;

use App\Models\Item;
use Illuminate\Support\Collection;

use Illuminate\Support\Str;
use App\Services\Instances\ItemInstance;

trait HasItems
{
    public function getItems(): Collection
    {
        $items = collect($this->items ?? []);

        return $items->map(function ($data) {
            $item = (object) $data;
            return $item;
        });
    }
    public function getItemsModels(): Collection
    {
        $items = collect($this->items ?? []);
        // $itemModels = Item::whereIn('id', $items->pluck('id'))->get()->keyBy('id');

        // return $items->map(function ($data) use ($itemModels) {
        //     $item = (object) $data;
        //     $item->model = $itemModels->get($item->id);
        //     return $item;
        // });

        return $items->map(function ($data) {
            return new ItemInstance($data);
        });
    }

    public function saveItems(Collection $items): void
    {
        $this->items = $items->map(fn($i) => (array) $i)->toArray();
        $this->save();
    }

    public function addItem(array $newItem): void
    {
        $items = $this->getItems();
        $base = Item::find($newItem['id']);
        if (!$base) return;

        $maxStack = max(1, (int) $base->max_stack);
        $remaining = $newItem['stack'];

        $items->each(function ($item) use (&$remaining, $newItem, $maxStack) {
            $item->modifiers ??= [];
            $item->properties ??= [];
            $item->sockets ??= [];

            if (
                $item->id === $newItem['id'] &&
                $item->modifiers == $newItem['modifiers'] &&
                $item->properties == $newItem['properties'] &&
                $item->sockets == $newItem['sockets'] &&
                ($item->stack ?? 1) < $maxStack
            ) {
                $space = $maxStack - $item->stack;
                $toAdd = min($space, $remaining);
                $item->stack += $toAdd;
                $remaining -= $toAdd;
            }
        });

        while ($remaining > 0) {
            $stackSize = min($remaining, $maxStack);

            $newItem['uuid'] = (string) Str::uuid();
            $newItem['stack'] = $stackSize;

            $items->push((object)$newItem);

            $remaining -= $stackSize;
        }

        $this->saveItems($items);
    }


    public function addItems(array $items): void
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    public function removeItem(string $uuid, int $count = 1): void
    {
        $items = $this->getItems();

        $items = $items->flatMap(function ($item) use ($uuid, $count) {
            if ($item->uuid !== $uuid) return [$item];

            if ($item->stack > $count) {
                $item->stack -= $count;
                return [$item];
            }

            // Удаляем предмет полностью
            return [];
        });

        $this->saveItems($items);
    }

    public function transferItemTo($target, string $uuid, int $count = 1): void
    {
        $item = $this->findItem($uuid);
        if (!$item) return;

        // Создаём копию с нужным количеством
        $transfer = (array) $item;
        $transfer['stack'] = $count;

        // Добавляем в другой контейнер
        $target->addItem($transfer);

        // Удаляем из текущего
        $this->removeItem($uuid, $count);
    }
    public function findItem(string $uuid)
    {
        return $this->getItems()->firstWhere('uuid', $uuid);
    }
    public function getTotalWeight(): float
    {
        return $this->getItems()->sum(function ($item) {
            $model = Item::find($item->id);
            return ($model->getWeight()?? 0) * ($item->stack ?? 1);
        });
    }
    // Предметы, которые можно разобрать на компоненты
    public function getDisassembleItems(int $level): Collection
    {
        return $this->getItemsModels()->filter(function ($entry) use ($level) {
            return !empty($entry->model->craft) && ($entry->model->min_level ?? 0) <= $level;
        })->values();
    }

    // Все шаблоны, доступные для крафта
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

    // Только те шаблоны, на которые хватает компонентов
    public function getAvailableCrafts(int $level): Collection
    {
        $inventory = $this->getItems()->mapWithKeys(function ($entry) {
            return [$entry->id => ($entry->stack ?? 1)];
        });

        return $this->getCraftableItems($level)
            ->filter(function ($item) use ($inventory) {
                foreach ($item->craft as $component) {
                    if (
                        !isset($inventory[$component['item']]) ||
                        $inventory[$component['item']] < $component['stack']
                    ) {
                        return false;
                    }
                }
                return true;
            })
            ->values();
    }
    public function hasRequiredResources(array $recipe): bool
{
    $items = $this->getItems();
    foreach ($recipe as $req) {
        $have = $items
            ->where('id', $req['item'])
            ->sum('stack');

        if ($have < $req['stack']) return false;
    }
    return true;
}
public function removeResources(array $recipe): void
{
    foreach ($recipe as $req) {
        $need = $req['stack'];
        $items = $this->getItems()->where('id', $req['item']);

        foreach ($items as $item) {
            if ($need <= 0) break;

            $remove = min($item->stack, $need);
            $this->removeItem($item->uuid, $remove);
            $need -= $remove;
        }
    }
}

}
