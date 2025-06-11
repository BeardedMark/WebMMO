<?php

namespace App\Domains\Enemies\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Domains\Enemies\Models\Enemy;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Services\CombatService;
use App\Domains\Items\Services\ItemService;

class EnemyController extends Controller
{
    public function index()
    {
        $enemies = Enemy::all();
        return view('db.enemies.index', compact('enemies'));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(Enemy $enemy)
    {
        return view('db.enemies.show', compact('enemy'));
    }

    public function edit(Enemy $enemy) {}

    public function update(Request $request, Enemy $enemy) {}

    public function destroy(Enemy $enemy) {}

    public function battle($uuid, Request $request)
    {
        $character = Auth::user()->currentCharacter();
        $transition = $character->transition;

        $enemies = $transition->findEnemyByUuid($uuid);
        if (!$enemies) {
            $character->addLog('EnemyController.battle', "Враг не найден");
            return back();
        }

        $character->addLog('EnemyController.battle', "⚔️ Начинается бой c x{$enemies->getStack()} {$enemies->getModel()->getTitle()} {$enemies->getLevel()} ур");

        for ($i = 1; $i <= $enemies->getStack(); $i++) {
            $result = CombatService::autoFightVsBot($character, $enemies);

            if (!$result) {
                $character->reduceExperience($enemies->getHealth());

                // ItemService::generateFromList($transition, $character->getInventorySummary(), -$character->getLuck());
                $character->addLog('EnemyController.battle', "⚔️ Вы проиграли бой");
                return back();
            }

            $transition->removeEnemy($uuid);
            $itemsList = $enemies->getModel()->getDropList();

            ItemService::generateFromList($transition, $enemies->getLevel(), $itemsList, $character->getLuck());

            $character->increaseExperience($enemies->getHealth() + $enemies->getDamage());

            if ($i < $enemies->getStack()) {
                $character->addLog('EnemyController.battle', "{$i} {$enemies->getModel()->getTitle()} повержен");
            }
        }

        $character->addLog('EnemyController.battle', "⚔️ Вы выиграли бой");
        return back();
    }
}
