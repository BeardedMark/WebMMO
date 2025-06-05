<?php

namespace App\Services\Factories;

use App\Domains\Containers\Models\Container;
use App\Services\Instances\ContainerInstance;
use Illuminate\Support\Str;
use App\Domains\Modifiers\Services\ModifierService;

class ContainerFactory
{
    public static function make(string $code, int $stack = 1): ?ContainerInstance
    {
        $model = Container::where('code', $code)->first();
        if (!$model) return null;

        return new ContainerInstance([
            'uuid' => (string) Str::uuid(),
            'code' => $model->code,
            'stack' => $stack,
            'modifiers' => [],
            'properties' => [],
            'requirements' => $model->requirements ?? [],
            'items' => $model->items ?? [],
        ]);
    }

    public static function makeClean(string $code, int $stack = 1): ?ContainerInstance
    {
        $model = Container::where('code', $code)->first();
        if (!$model) return null;

        return new ContainerInstance([
            'uuid' => (string) Str::uuid(),
            'code' => $model->code,
            'stack' => $stack,
            'modifiers' => [],
            'properties' => [],
            'requirements' => $model->requirements ?? [],
            'items' => $model->items ?? [],
        ]);
    }
}
