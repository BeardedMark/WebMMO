<?php

namespace App\Services;

use App\Domains\Characters\Models\Character;
use App\Domains\Locations\Models\Location;
use App\Models\Transition;
use App\Models\Road;
use App\Domains\Items\Services\ItemService;
use App\Domains\Enemies\Services\EnemySpawner;
use Illuminate\Support\Facades\DB;
use App\Domains\Modifiers\Services\ModifierService;

class MovementService
{
    public function moveToLocation(Character $character, Location $location): ?Transition
    {
        if (!$character->isAvailable()) return null;

        $currentLocation = $character->location;
        $road = Road::betweenRoad($currentLocation, $location)->first();

        if (!$road || !$road->is_open) return null;

        return DB::transaction(function () use ($character, $location, $road) {
            $transition = $character->allTransitions()->create([
                'location_id' => $location->id,
            ]);

            $modifiers = ModifierService::rollDynamicModifiers($transition->location->modifiers ?? []);
            $transition->setModifiers($modifiers);

            $items = ItemService::generateItems($location->getSize(), $location->getLevel(), $location->availableItems(), $character->dropChanceBonus());
            $transition->addItems($items);

            $enemies = EnemySpawner::spawn($location->getSize(), $location->getLevel(), $location->availableEnemies(), $character->dropChanceBonus());
            $transition->addEnemies($enemies);

            // $containers = ContainerSpawner::spawn($location->getSize(), $location->availableItems(), $character->dropChanceBonus());
            // $transition->addContainers($containers);

            $timeToRoad = $road->getDistance() / ($character->getMoveSpeed() / 3.6);
            $timeToLocation = $location->getSize() / ($character->getMoveSpeed() / 3.6);
            $delay = floor($timeToRoad + $timeToLocation * 10 / 2 + $character->overWeight());

            $character->setDelayToNextAction($delay);
            $character->addLog('MovementService.moveToLocation', "Вход в {$location->name}, задержка {$delay} сек");

            $this->enemyAutoAggro($character, $transition);

            return $transition;
        });
    }

    public function refreshLocation(Character $character, Transition $transition): void
    {
        $location = $transition->location;

        $transition->update([
            'inventory' => [],
            'containers' => [],
            'enemies' => [],
        ]);

        $modifiers = ModifierService::rollDynamicModifiers($transition->location->modifiers ?? []);
        $transition->setModifiers($modifiers);

        $items = ItemService::generateItems($location->getSize(), $location->getLevel(), $location->availableItems(), $character->dropChanceBonus());
        $transition->addItems($items);

        $enemies = EnemySpawner::spawn($location->getSize(), $location->getLevel(), $location->availableEnemies(), $character->dropChanceBonus());
        $transition->addEnemies($enemies);

        // $containers = ContainerSpawner::spawn($location->getSize(), $location->availableContainers(), $character->dropChanceBonus());
        // $transition->addContainers($containers);

        $timeToLocation = $location->getSize() / ($character->getMoveSpeed() / 3.6);
        $delay = floor($timeToLocation * 10 + $character->overWeight());
        $character->setDelayToNextAction($delay);

        $character->addLog('MovementService.refreshLocation', "Переобход {$location->name}, задержка {$delay} сек");

        $this->enemyAutoAggro($character, $transition);
    }

    protected function enemyAutoAggro(Character $character, Transition $transition): void
    {
        $location = $transition->location;

        if ($location->isPeaceful() || $character->getLevel() >= $location->level) return;

        $enemies = $transition->getEnemies();

        foreach ($enemies->shuffle() as $enemy) {
            if (rand(1, 100) <= 25) { // шанс нападения
                $character->addLog('MovementService.enemyAutoAggro', "На вас нападает {$enemy->getModel()->getTitle()}!");

                $result = CombatService::autoFightVsBot($character, $enemy, true);

                if ($result) {
                    $transition->removeEnemy($enemy->getUuid());
                    $itemsList = $enemy->getModel()->getDropList();

                    ItemService::generateFromList($transition, $enemy->getLevel(), $itemsList, $character->getLuck());

                    $character->increaseExperience(($enemy->getHealth() + $enemy->getDamage()) / 2);
                    $character->addLog('MovementService.enemyAutoAggro', "Вы отбились от врага");
                } else {
                    $character->reduceExperience($enemy->getHealth());
                    $character->addLog('MovementService.enemyAutoAggro', "Вы проиграли. Нападения прекращены.");
                    break;
                }
            }
        }
    }
}
