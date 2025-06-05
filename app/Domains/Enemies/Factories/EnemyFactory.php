<?php

namespace App\Domains\Enemies\Factories;

use App\Domains\Enemies\Models\Enemy;
use App\Domains\Enemies\Instances\EnemyInstance;
use App\Domains\Modifiers\Services\ModifierService;
use Illuminate\Support\Str;

class EnemyFactory
{
    public static function makeByCode(string $code, int $level, int $stack = 1): ?EnemyInstance
    {
        $model = Enemy::where('code', $code)->first();
        if (!$model) return null;

        return new EnemyInstance([
            'uuid' => (string) Str::uuid(),
            'code' => $model->code,
            'id' => $model->id,
            'level' => $level,
            'stack' => $stack,
            'modifiers' => ModifierService::rollStaticModifiers($model->modifiers ?? []),
        ]);
    }
}
