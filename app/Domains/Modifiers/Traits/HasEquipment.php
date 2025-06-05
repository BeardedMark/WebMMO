<?php

namespace App\Domains\Modifiers\Traits;

use App\Domains\Items\Models\Item;
use Illuminate\Support\Collection;

use Illuminate\Support\Str;
use App\Domains\Items\Instances\ItemInstance;

trait HasEquipment
{
    public function getEquipment(): Collection
    {
        $items = collect($this->equipment ?? []);
        return $items->map(fn($data) => new ItemInstance($data));
    }

    public function saveEquipment(Collection $equipment): void
    {
        $this->equipment = $equipment->map(fn($e) => method_exists($e, 'getData') ? $e->getData() : (array) $e)->toArray();
        $this->save();
    }

    public function getEquippedBySlot(string $slot): ?ItemInstance
    {
        return $this->getEquipment()
            ->first(fn($item) => $item instanceof ItemInstance && $item->getSlot() === $slot);
    }


    public function isSlotEquipped(string $slot): bool
    {
        return $this->getEquippedBySlot($slot) !== null;
    }


    public function equip(ItemInstance $item): bool
    {
        $itemSlot = $item->getSlot();
        if (!$itemSlot) return false;

        // Если в этом слоте уже что-то есть — снимаем
        $existing = $this->getEquippedBySlot($itemSlot);
        if ($existing) {
            $unequipped = $this->unequip($existing->getUuid());
            if ($unequipped) {
                $this->addItem($unequipped); // вернули в инвентарь
            }
        }

        // Добавляем в экипировку
        $equipment = $this->getEquipment(); // Collection<ItemInstance>
        $equipment->push($item);
        $this->saveEquipment($equipment);

        return true;
    }

    public function unequip(string $uuid): ?ItemInstance
    {
        $equipment = $this->getEquipment(); // Collection<ItemInstance>

        $item = $equipment->first(fn($i) => $i->getUuid() === $uuid);
        if (!$item) return null;

        $updated = $equipment->reject(fn($i) => $i->getUuid() === $uuid);
        $this->saveEquipment($updated);

        return $item;
    }



    public function getEquipmentStats(): array
    {
        $stats = [];

        $this->getEquipment()->each(function ($item) use (&$stats) {
            $modifiers = $item->getModifierInstances(); // ← возвращает Collection<ModifierInstance>

            foreach ($modifiers as $mod) {
                $code = $mod->getCode();
                $value = $mod->getValue() ?? 0;

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


public function getEquipmentModifiers(): Collection
{
    $all = collect();

    // Собираем все модификаторы с предметов
    $this->getEquipment()->each(function ($item) use (&$all) {
        $all = $all->merge($item->getModifierInstances()); // каждый вернет Collection<ModifierInstance>
    });

    // Группируем по коду и модифицируем существующий инстанс
    $summed = $all->groupBy(fn($mod) => $mod->getCode())
        ->map(function (Collection $mods) {
            /** @var ModifierInstance $first */
            $first = $mods->first();
            $sum = $mods->sum(fn($m) => $m->getValue());
            $first->setValue($sum);
            return $first;
        })
        ->values();

    return $summed;
}

}
