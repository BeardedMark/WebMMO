<?php

namespace App\Domains\Enemies\Traits;

use App\Domains\Enemies\Instances\EnemyInstance;
use Illuminate\Support\Collection;

trait HasEnemies
{
    public function getEnemies(): Collection
    {
        return collect($this->enemies ?? [])->map(fn($data) => new EnemyInstance($data));
    }

    public function addEnemy(EnemyInstance $new): void
    {
        $list = $this->getEnemies();
        $added = false;

        foreach ($list as $enemy) {
            if (
                $enemy->getCode() === $new->getCode()
                //  &&
                // $enemy->getModifierInstances() == $new->getModifierInstances()

            ) {
                $enemy->data['stack'] += $new->getStack();
                $added = true;
                break;
            }
        }

        if (!$added) {
            if (!$new->getUuid()) {
            }
            $list->push($new);
        }

        $this->enemies = $list->map(fn($e) => $e->getData())->toArray();
        $this->save();
    }

    public function addEnemies(array $enemies): void
    {
        foreach ($enemies as $enemy) {
            if ($enemy instanceof EnemyInstance) {
                $this->addEnemy($enemy);
            }
        }
    }

    public function removeEnemy(string $uuid): void
    {
        $this->enemies = $this->getEnemies()
            ->reject(fn($e) => $e->getUuid() === $uuid)
            ->map(fn($e) => $e->getData())
            ->toArray();
        $this->save();
    }

    public function findEnemyByUuid(string $uuid): ?EnemyInstance
    {
        return $this->getEnemies()->first(fn($e) => $e->getUuid() === $uuid);
    }
}
