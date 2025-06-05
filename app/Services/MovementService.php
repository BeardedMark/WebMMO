<?php

namespace App\Services;

use App\Domains\Characters\Models\Character;
use App\Domains\Locations\Models\Location;
use App\Models\Transition;
use App\Models\Road;
use App\Domains\Items\Services\LootService;
use App\Domains\Enemies\Services\EnemySpawner;
use Illuminate\Support\Facades\DB;
use App\Domains\Modifiers\Services\ModifierService;

class MovementService
{
    public function moveTo(Character $character, Location $to): ?Transition
    {
        if (!$character->isAvailable()) return null;

        $from = $character->location;
        $road = Road::betweenRoad($from, $to)->first();

        if (!$road || !$road->is_open) return null;

        return DB::transaction(function () use ($character, $to, $road) {
            $items = LootService::generateItems($to->getSize(), $to->availableItems(), $character->dropChanceBonus());
            // $containers = ContainerSpawner::spawn($to->getSize(), $to->availableItems(), $character->dropChanceBonus());
            $enemies = EnemySpawner::spawn($to->getSize(), $to->getLevel(), $to->availableEnemies(), $character->dropChanceBonus());

            $transition = $character->allTransitions()->create([
                'location_id' => $to->id,
            ]);
            $transition->addItems($items);
            // $transition->addContainers($containers);
            $transition->addEnemies($enemies);
            $transition->setModifiers(ModifierService::rollDynamicModifiers($transition->location->modifiers ?? []));

            $delay = $road->getDistance() + $to->getSize() + $character->overWeight();
            // $character->setDelayToNextAction($delay);

            $character->addLog('transitions', "Вход в {$to->name}, задержка {$delay} сек");

            $this->enemyAutoAggro($character, $transition);

            return $transition;
        });
    }

    public function refreshLocation(Character $character, Transition $transition): void
    {
        $location = $transition->location;

        $loot = LootService::generateItems($location->getSize(), $location->availableItems(), $character->dropChanceBonus());
        // $containers = ContainerSpawner::spawn($location->getSize(), $location->availableContainers(), $character->dropChanceBonus());
        $enemies = EnemySpawner::spawn($location->getSize(), $location->getLevel(), $location->availableEnemies(), $character->dropChanceBonus());

        $transition->update([
            'inventory' => [],
            'containers' => [],
            'enemies' => [],
        ]);
        $transition->addItems($loot);
        // $transition->addContainers($containers);
        $transition->addEnemies($enemies);
        $transition->setModifiers(ModifierService::rollDynamicModifiers($transition->location->modifiers ?? []));

        $delay = $location->getSize() + $character->overWeight();
        // $character->setDelayToNextAction($delay);
        $character->addLog('transitions', "Переобход {$location->name}, задержка {$delay} сек");

        $this->enemyAutoAggro($character, $transition);
    }

    protected function enemyAutoAggro(Character $character, Transition $transition): void
    {
        $location = $transition->location;

        if ($location->isPeaceful() || $character->getLevel() >= $location->level) return;

        $enemies = $transition->getEnemies();

        foreach ($enemies->shuffle() as $enemy) {
            if (rand(1, 100) <= 50) { // шанс нападения, можно вынести в config
                $character->addLog('auto-aggro', "На вас нападает {$enemy->getModel()->getTitle()}!");

                $result = CombatService::fight($character, $enemy);

                if ($result) {
                    $transition->removeEnemy($enemy->getUuid());
                    $itemsList = $enemy->getModel()->getDropList();
                    LootService::generateFromList($transition, $itemsList, $character->getLuck());

                    $character->increaseExperience($enemy->getHealth() + $enemy->getDamage());
                    $character->addLog('auto-aggro', "Вы отбились от врага");
                } else {
                    $character->reduceExperience($enemy->getHealth());
                    $character->addLog('auto-aggro', "Вы проиграли. Нападения прекращены.");
                    break;
                }
            }
        }
    }
}
