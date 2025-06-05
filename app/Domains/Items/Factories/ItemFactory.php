<?php

namespace App\Domains\Items\Factories;

use App\Domains\Items\Models\Item;
use App\Domains\Items\Instances\ItemInstance;
use App\Domains\Modifiers\Services\ModifierService;
use Illuminate\Support\Str;

class ItemFactory
{
    /**
     * Создание экземпляра по коду
     */
    public static function makeByCode(string $code, int $stack = 1): ?ItemInstance
    {
        $model = Item::where('code', $code)->first();
        return $model ? self::makeFromModel($model, $stack) : null;
    }

    /**
     * Создание экземпляра по модели
     */
    public static function makeFromModel(Item $model, int $stack = 1): ItemInstance
    {
        return new ItemInstance([
            'uuid' => (string) Str::uuid(),
            'code' => $model->code,
            'stack' => $stack,
            'modifiers' => ModifierService::rollDynamicModifiers($model->modifiers ?? []),
        ]);
    }
}
