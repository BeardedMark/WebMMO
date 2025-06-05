<?php

namespace App\Domains\Modifiers\Services;

use App\Domains\Modifiers\Models\Modifier;
use App\Domains\Modifiers\Factories\ModifierFactory;
use Illuminate\Support\Collection;


class ModifierService
{
    public static function getModifierInstances(array $modifiers): Collection
    {
        return collect($modifiers)
            ->map(function ($mod) {
                return ModifierFactory::makeByData($mod);
            })
            ->filter()
            ->values();
    }

    public static function sumModifiers(array|Collection $modifiers): Collection
    {
        $collection = collect($modifiers)->map(function ($mod) {
            return is_array($mod)
                ? ModifierFactory::makeByData($mod)
                : $mod;
        })->filter();

        $summed = [];

        foreach ($collection as $modifier) {
            $code = $modifier->getCode();
            $value = $modifier->getValue() ?? 0;

            if (!isset($summed[$code])) {
                $summed[$code] = [
                    'code' => $code,
                    'name' => $modifier->getName(),
                    'value' => 0,
                ];
            }

            $summed[$code]['value'] += $value;
        }

        return collect($summed)
            ->map(fn($data) => ModifierFactory::makeByData($data))
            ->values();
    }


    /**
     * Генерирует набор модификаторов по коду
     */
    public static function rollStaticModifiers(array $modifiers): array
    {
        $codes = collect($modifiers)->pluck('code')->all();
        $defs = Modifier::whereIn('code', $codes)->get()->keyBy('code');

        $grouped = collect($modifiers)->groupBy('code');

        return $grouped->map(function ($items, $code) use ($defs) {
            if (!isset($defs[$code])) return null;

            $def = $defs[$code];
            $total = $items->count() * $def->value;

            return [
                'code' => $def->code,
                'name' => $def->name,
                'value' => $total,
            ];
        })->filter()->values()->toArray();
    }

    /**
     * Генерирует свойства по массиву [code, value]
     */
    public static function rollDynamicModifiers(array $modifiers, int $max = 6): array
    {
        if (empty($modifiers)) return [];

        $codes = collect($modifiers)->pluck('code')->all();
        $defs = Modifier::whereIn('code', $codes)->get()->shuffle()->values();
        if ($defs->isEmpty()) return [];

        $targetCount = rand(0, $max);
        $result = [];

        for ($i = 0; $i < $targetCount; $i++) {
            $mod = $defs->random();

            $rolledValue = self::rollValue($mod->value, $mod->spread);
            if (!isset($result[$mod->code])) {
                $result[$mod->code] = [
                    'code' => $mod->code,
                    'name' => $mod->name,
                    'value' => 0,
                ];
            }

            $result[$mod->code]['value'] += $rolledValue;
        }

        return array_values($result);
    }



    /**
     * Сам ролл значения (с учётом разброса)
     */
    public static function rollValue(float $base, ?float $spread = null): int
    {
        if ($spread == null) return $base;

        $min = (int) floor($base - ($base * $spread / 100));
        $max = (int) ceil($base + ($base * $spread / 100));
        return rand(max(1, $min), max(1, $max));
    }

    /**
     * Удаляет модификатор из массива по коду
     */
    public static function removeModifier(array &$mods, string $code): void
    {
        $mods = array_values(array_filter($mods, fn($m) => $m['code'] !== $code));
    }

    /**
     * Заменяет модификатор новым по коду
     */
    public static function replaceModifier(array &$mods, string $code, array $new): void
    {
        self::removeModifier($mods, $code);
        $mods[] = $new;
    }

    /**
     * Перероллить конкретный мод по коду
     */
    public static function rerollModifier(array &$mods, string $code): void
    {
        $def = Modifier::where('code', $code)->first();
        if (!$def) return;

        foreach ($mods as &$mod) {
            if ($mod['code'] === $code) {
                $mod['value'] = self::rollValue($def->value, $def->spread);
            }
        }
    }

    /**
     * Массовая перероллка всех модификаторов
     */
    public static function rerollAll(array &$mods): void
    {
        foreach ($mods as &$mod) {
            $def = Modifier::where('code', $mod['code'])->first();
            if ($def) {
                $mod['value'] = self::rollValue($def->value, $def->spread);
            }
        }
    }
}
