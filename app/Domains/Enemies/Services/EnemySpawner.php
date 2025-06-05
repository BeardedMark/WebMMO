<?php

namespace App\Domains\Enemies\Services;

use App\Domains\Enemies\Models\Enemy;
use App\Domains\Enemies\Factories\EnemyFactory;
use Illuminate\Support\Collection;

class EnemySpawner
{
    public static function spawn(int $count, int $level, Collection $enemies, float $bonusChance = 0): array
    {
        $result = [];
        $targetCount = rand(0, $count);
        $attempts = 0;
        $maxAttempts = $targetCount * 5;

        if ($enemies->isEmpty()) return [];

        while (count($result) < $targetCount && $attempts < $maxAttempts) {
            /** @var Enemy $enemy */
            $enemy = $enemies->random();
            $chance = $enemy->spawn_chance + ($enemy->spawn_chance * $bonusChance / 100);

            if (rand(1, 10000) <= $chance * 100) {
                $instance = EnemyFactory::makeByCode($enemy->code, $level);
                if ($instance) $result[] = $instance;
            }

            $attempts++;
        }

        return $result;
    }
}
