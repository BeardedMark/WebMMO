<?php

namespace App\Services;

use App\Domains\Containers\Models\Container;
use App\Services\Factories\ContainerFactory;
use Illuminate\Support\Collection;

class ContainerSpawner
{
    public static function spawn(int $count, Collection $containers, float $bonusChance = 0): array
    {
         $result = [];
        $targetCount = rand(0, $count);
        $attempts = 0;
        $maxAttempts = $targetCount * 5;

        if ($containers->isEmpty()) return [];

        while (count($result) < $targetCount && $attempts < $maxAttempts) {
            /** @var Container $object */
            $object = $containers->random();
            $chance = $object->spawn_chance + ($object->spawn_chance * $bonusChance / 100);

            if (rand(1, 10000) <= $chance * 100) {
                $instance = ContainerFactory::makeClean($object->code);
                if ($instance) $result[] = $instance;
            }

            $attempts++;
        }

        return $result;
    }
}
