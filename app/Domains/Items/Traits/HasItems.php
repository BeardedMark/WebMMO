<?php

namespace App\Domains\Items\Traits;

use App\Domains\Items\Models\Item;
use Illuminate\Support\Collection;

use Illuminate\Support\Str;
use App\Domains\Items\Services\ItemService;
use App\Domains\Items\Instances\ItemInstance;


trait HasItems
{
    public function getItems(): Collection
    {
        $items = collect($this->inventory ?? []);
        return $items->map(fn($data) => new ItemInstance($data));
    }

    public function getInventorySummary(): array
    {
        return $this->getItems()
            ->groupBy(fn($item) => $item->getCode())
            ->map(function ($group) {
                return [
                    'code' => $group->first()->getCode(),
                    'stack' => $group->sum(fn($item) => $item->getStack()),
                ];
            })->values()->toArray();
    }

    public function saveItems(Collection $items): void
    {
        $this->inventory = $items->map(fn($item) => method_exists($item, 'toArray') ? $item->toArray() : (array) $item)->toArray();
        $this->save();
    }

    public function addItem(ItemInstance $newItem): void
    {
        $items = $this->getItems();
        $code = $newItem->getCode();
        $added = false;

        $items->each(function ($item) use (&$added, $newItem, $code) {
            if ($item->getCode() === $code &&
                $item->getModifierInstances() == $newItem->getModifierInstances()) {
                $item->increaseStack($newItem->getStack());
                $added = true;
            }
        });

        if (!$added) {
            // dd($newItem);
            $items->push($newItem);
        }

        $this->saveItems($items);
    }


    public function addItems(array|Collection $items): void
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    public function removeItem(string $uuid, int $count = 1): void
    {
        $items = $this->getItems()->flatMap(function ($item) use ($uuid, $count) {
            if ($item->getUuid() !== $uuid) return [$item];

            if ($item->getStack() > $count) {
                $item->decreaseStack($count);
                return [$item];
            }

            return []; // удалить
        });

        $this->saveItems($items);
    }

    public function transferItemTo($target, string $uuid, int $count = 1): void
    {
        $item = $this->findItemByUuid($uuid);
        if (!$item) return;

        // $transfer = new ItemInstance($item->getData());
        $item->setStack($count);

        $target->addItem($item);
        $this->removeItem($uuid, $count);
    }

    public function findItemByUuid(string $uuid): ?ItemInstance
    {
        return $this->getItems()->first(fn($item) => $item->getUuid() === $uuid);
    }

    public function getTotalWeight(): float
    {
        return $this->getItems()->sum(function ($item) {
            $model = Item::where('code', $item->getCode())->first();
            return ($model?->getWeight() ?? 0) * $item->getStack();
        });
    }

    public function getDisassembleItems(int $level): Collection
    {
        return $this->getItems()->filter(function ($entry) use ($level) {
            $model = Item::where('code', $entry->getCode())->first();
            return !empty($model?->craft) && ($model->min_level ?? 0) <= $level;
        })->values();
    }

    public function getCraftableItems(int $level): Collection
    {
        return Item::query()
            ->whereNotNull('craft')
            ->where(function ($query) use ($level) {
                $query->whereNull('min_level')->orWhere('min_level', '<=', $level);
            })->get();
    }

    public function getAvailableCrafts(int $level): Collection
    {
        $inventory = $this->getItems()->mapWithKeys(fn($entry) => [$entry->getCode() => $entry->getStack()]);

        return $this->getCraftableItems($level)->filter(function ($item) use ($inventory) {
            foreach ($item->craft as $component) {
                if (
                    !isset($inventory[$component['code']]) ||
                    $inventory[$component['code']] < $component['stack']
                ) {
                    return false;
                }
            }
            return true;
        })->values();
    }

    public function hasRequiredResources(array $recipe): bool
    {
        $items = $this->getItems();

        foreach ($recipe as $req) {
            $have = $items->filter(fn($i) => $i->getCode() === $req['code'])->sum(fn($i) => $i->getStack());
            if ($have < $req['stack']) return false;
        }

        return true;
    }

    public function removeResources(array $recipe): void
    {
        foreach ($recipe as $req) {
            $need = $req['stack'];

            foreach ($this->getItems()->filter(fn($i) => $i->getCode() === $req['code']) as $item) {
                if ($need <= 0) break;

                $remove = min($item->getStack(), $need);
                $this->removeItem($item->getUuid(), $remove);
                $need -= $remove;
            }
        }
    }
}
