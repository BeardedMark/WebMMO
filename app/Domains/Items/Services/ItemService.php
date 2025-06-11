<?php

namespace App\Domains\Items\Services;

use App\Domains\Items\Models\Item;
use App\Domains\Items\Instances\ItemInstance;
use App\Domains\Items\Factories\ItemFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ItemService
{
    /**
     * Генерация предметов по шансу
     */
    public static function generateItems(int $count, int $level, Collection $items, float $bonusChance = 0): array
    {
        return self::generateFromPool($count, $level, $items, $bonusChance);
    }

    /**
     * Унифицированная генерация лута с весами
     */
    protected static function generateFromPool(int $count, int $level, Collection $poolItems, float $bonusChance = 0): array
    {
        $result = [];
        $targetCount = rand(0, $count);
        $attempts = 0;
        $maxAttempts = $targetCount * 5;

        while (count($result) < $targetCount && $attempts < $maxAttempts) {
            /** @var Item $item */
            $item = $poolItems->random();

            $chance = $item->getDropChance() + $item->getDropChance() * ($bonusChance / 100);

            if (rand(1, 10000) <= $chance * 100) {
                // защита от повторов (если надо)
                $result[] = ItemFactory::makeFromModel($item, $level);
            }

            $attempts++;
        }

        return $result;
    }

    /**
     * Генерация по списку
     */
    public static function generateFromList($container, int $level, array $itemsList, float $bonusChance = 0): void
    {
        foreach ($itemsList as $item) {
            $itemInstance = ItemFactory::makeByCode($item['code'], $level);
            $itemModel = $itemInstance->getModel();

            $baseChance = $component['chance'] ?? $itemModel->getDropChance() ?? 100;
            $finalChance = min(100, $baseChance + $bonusChance);

            $loot = ItemService::generateItems($item['stack'], $level, collect([$itemModel]), $finalChance);
            $container->addItems($loot);

            // self::lootFromObject($container, $item['stack'], collect([$itemModel]), $finalChance);
        }
    }
}
