<?php

namespace App\Domains\Items\Services;

use App\Domains\Items\Models\Item;
use App\Domains\Items\Instances\ItemInstance;

class ResourceService
{
    /**
     * Проверяет, достаточно ли ресурсов
     */
    public static function canConsume($container, array $recipe): bool
    {
        $inventory = $container->getItems();

        foreach ($recipe as $req) {
            $have = $inventory->filter(fn($i) => $i->getCode() === $req['code'])->sum(fn($i) => $i->getStack());
            if ($have < $req['stack']) return false;
        }

        return true;
    }

    /**
     * Потребляет ресурсы, если хватает
     */
    public static function consume($container, array $recipe): bool
    {
        if (!self::canConsume($container, $recipe)) return false;

        foreach ($recipe as $req) {
            $need = $req['stack'];

            foreach ($container->getItems()->filter(fn($i) => $i->getCode() === $req['code']) as $entry) {
                if ($need <= 0) break;

                $remove = min($entry->getStack(), $need);
                $container->removeItem($entry->getUuid(), $remove);
                $need -= $remove;
            }
        }

        return true;
    }

    /**
     * Возвращает, сколько предметов не хватает
     */
    public static function previewShortage($container, array $recipe): array
    {
        $inventory = $container->getItems();
        $missing = [];

        foreach ($recipe as $req) {
            $have = $inventory->filter(fn($i) => $i->getCode() === $req['code'])->sum(fn($i) => $i->getStack());
            $short = $req['stack'] - $have;

            if ($short > 0) {
                $missing[] = [
                    'code' => $req['code'],
                    'missing' => $short
                ];
            }
        }

        return $missing;
    }
}
