<?php

namespace App\Domains\Items\Services;

use App\Domains\Items\Models\Item;
use App\Domains\Items\Instances\ItemInstance;
use App\Domains\Items\Factories\ItemFactory;
use App\Services\RequirementService;

class CraftingService
{
    /**
     * Сборка предмета
     */
    public static function assemble($container, Item $item): ?ItemInstance
    {
        if (!ResourceService::canConsume($container, $item->getCraftArray())) {
            return null;
        }
        if ($item->requirements && !RequirementService::check($container, $item->requirements)) {
            return null;
        }

        ResourceService::consume($container, $item->getCraftArray());

        $crafted = ItemFactory::makeFromModel($item, 1);
        $container->addItem($crafted);

        return $crafted;
    }

    /**
     * Разбор предмета
     */
    public static function disassemble($container, ItemInstance $instance): void
    {
        $item = $instance->getModel();
        if (!$item || empty($item->getCraftArray())) return;

        $container->removeItem($instance->getUuid());

        $bonusChance = 30;

        foreach ($item->getCraftArray() as $component) {
            $componentItem = Item::where('code', $component['code'])->first();
            if (!$componentItem) continue;

            $stack = $component['stack'] ?? 1;
            $baseChance = $component['chance'] ?? $componentItem->drop_chance ?? 100;
            $finalChance = min(100, $baseChance + $bonusChance);

            LootService::lootFromObject($container, $stack, collect([$componentItem]), $finalChance);
        }
    }
}
