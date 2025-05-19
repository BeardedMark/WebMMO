<?php

namespace App\Traits;

use App\Models\Item;
use Illuminate\Support\Collection;

use Illuminate\Support\Str;
use App\Services\Instances\ItemInstance;

trait HasEquipment
{
    public function getEquipmentModels(): Collection
    {
        $items = collect($this->equipment ?? []);

        $itemModels = Item::whereIn('id', $items->pluck('id'))->get()->keyBy('id');

        return $items->map(function ($data) use ($itemModels) {
            $item = (object) $data;
            $item->model = $itemModels->get($item->id);
            return $item;
        });
    }
    public function getEquipment(): Collection
    {
        return collect($this->equipment ?? []);
    }

    public function saveEquipment(Collection $equipment): void
    {
        $this->equipment = $equipment->map(fn($i) => (array) $i)->toArray();
        $this->save();
    }

    public function getEquippedByClass(string $class)
    {
        $item = $this->getEquipmentModels()->firstWhere('class', $class);
        if (!$item) return null;

        return new ItemInstance($item);
    }

    public function isClassEquipped(string $class): bool
    {
        return $this->getEquippedByClass($class) !== null;
    }

    public function equip(object $item): bool
    {
        $equipment = $this->getEquipment();
        $itemClass = $item->class ?? null;
        if (!$itemClass) return false;

        // Найти уже экипированный предмет того же класса
        $existing = $equipment->firstWhere('class', $itemClass);

        // Если был — вернуть в инвентарь
        if ($existing) {
            $this->addItem((array) $existing);
            $equipment = $equipment->reject(fn($i) => ($i['uuid'] ?? $i->uuid) === ($existing['uuid'] ?? $existing->uuid));
        }

        // Добавить новый
        $equipment->push($item);
        $this->saveEquipment($equipment);

        return true;
    }

    public function unequip(string $uuid): ?array
    {
        $equipment = $this->getEquipment();
        $item = $equipment->firstWhere('uuid', $uuid);
        if (!$item) return null;

        $equipment = $equipment->reject(fn($i) => $i->uuid === $uuid);
        $this->saveEquipment($equipment);
        return (array) $item;
    }

    public function getEquipmentStats(): array
    {
        $stats = [];

        $this->getEquipmentModels()->each(function ($item) use (&$stats) {
            $props = $item->properties ?? [];
            $mods = $item->modifiers ?? [];

            foreach ($props as $prop) {
                $code = $prop['code'] ?? null;
                $value = $prop['value'] ?? 0;
                if (!$code) continue;

                $stats[$code] = ($stats[$code] ?? 0) + $value;
            }

            foreach ($mods as $mod) {
                $code = $mod['code'] ?? null;
                $value = $mod['value'] ?? 0;
                if (!$code) continue;

                $stats[$code] = ($stats[$code] ?? 0) + $value;
            }
        });

        return $stats;
    }

    public function getEquipmentStat(string $code): int
    {
        $stats = $this->getEquipmentStats();
        return $stats[$code] ?? 0;
    }
}
