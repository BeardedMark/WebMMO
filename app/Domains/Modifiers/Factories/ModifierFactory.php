<?php

namespace App\Domains\Modifiers\Factories;

use App\Domains\Modifiers\Models\Modifier;
use App\Domains\Modifiers\Instances\ModifierInstance;
use Illuminate\Support\Str;

class ModifierFactory
{
    /**
     * Создать ModifierInstance из массива данных ['code' => ..., 'value' => ...]
     */
    public static function makeByData(array $data): ?ModifierInstance
    {
        if (!isset($data['code'])) return null;

        return self::makeByCode($data['code'], $data['value'] ?? null);
    }

    /**
     * Создать ModifierInstance по коду модификатора
     */
    public static function makeByCode(string $code, ?float $value = null): ?ModifierInstance
    {
        $model = Modifier::where('code', $code)->first();

        return $model ? self::makeFromModel($model, $value) : null;
    }

    /**
     * Создать ModifierInstance из модели Modifier, с возможным spread
     */
    public static function makeFromModel(Modifier $model, ?float $value = null): ModifierInstance
    {
        $baseValue = $value ?? $model->value;

        // if ($model->spread) {
        //     $spread = $model->spread;
        //     $baseValue *= mt_rand(1000 * (1 - $spread), 1000 * (1 + $spread)) / 1000;
        // }

        return new ModifierInstance([
            'uuid'  => (string) Str::uuid(),
            'code'  => $model->code,
            'name'  => $model->name,
            'value' => $baseValue,
        ]);
    }
}
