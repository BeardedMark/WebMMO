<?php

namespace App\Domains\Items\Services;

use App\Domains\Items\Models\Item;
use App\Domains\Items\Instances\ItemInstance;
use App\Domains\Items\Factories\ItemFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LootService
{
    /**
     * Генерация предметов по шансу
     */
    public static function generateItems(int $count, Collection $items, float $bonusChance = 0): array
    {
        return self::generateFromPool($count, $items, $bonusChance);
    }

    /**
     * Унифицированная генерация лута с весами
     */
    protected static function generateFromPool(int $count, Collection $poolItems, float $bonusChance = 0): array
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
                $result[] = ItemFactory::makeFromModel($item, 1);
            }

            $attempts++;
        }

        return $result;
    }

    /**
     * Выдать лут напрямую в модель с HasItems
     */
    public static function dropTo($container, int $count, Collection $items, float $chance = 0): void
    {
        $loot = self::generateItems($count, $items, $chance);
        $container->addItems($loot);
    }

    /**
     * Лут за квест или награду — по коду и количеству
     */
    public static function grantReward($container, array $reward): void
    {
        foreach ($reward as $itemCode => $stack) {
            $instance = ItemFactory::makeByCode($itemCode, $stack);
            if (!$instance) continue;
            $container->addItem($instance);
        }
    }

    /**
     * Лут из сундуков, объектов, ящиков
     */
    public static function lootFromObject($container, int $count, Collection $items, float $bonusChance = 0): array
    {
        $loot = self::generateItems($count, $items, $bonusChance);
        $container->addItems($loot);
        return $loot;
    }

    public static function generateFromList($container, array $itemsList, float $bonusChance = 0): void
    {
        foreach ($itemsList as $item) {
            $itemInstance = ItemFactory::makeByCode($item['code']);
            $itemModel = $itemInstance->getModel();

            $baseChance = $component['chance'] ?? $itemModel->getDropChance() ?? 100;
            $finalChance = min(100, $baseChance + $bonusChance);

            self::lootFromObject($container, $item['stack'], collect([$itemModel]), $finalChance);
        }
    }
}
