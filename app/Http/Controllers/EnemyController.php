<?php

namespace App\Http\Controllers;

use App\Models\Enemy;
use Illuminate\Http\Request;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class EnemyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enemies = Enemy::all();
        return view('db.enemies.index', compact('enemies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Enemy $enemy)
    {
        return view('db.enemies.show', compact('enemy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enemy $enemy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enemy $enemy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enemy $enemy)
    {
        //
    }

    public function battle(Request $request)
    {
        $request->validate([
            'enemy_id' => 'required|exists:enemies,id',
            'stack' => 'required|integer|min:1',
        ]);

        $enemyId = $request->enemy_id;
        $enemiesStackSize = $request->stack;

        $character = Auth::user()->character;
        $enemy = Enemy::findOrFail($enemyId);

        $transition = $character->latestTransition;
        $locationLevel = $transition->location->getLevel();

        $totalExperience = ($enemy->danger + $locationLevel) * $enemiesStackSize;

        $charHp = $character->getCurrentHealth();

        for ($i = 0; $i < $enemiesStackSize; $i++) {
            $enemyHp = ($enemy->health() + $locationLevel) * $enemy->danger;
            $enemyDmg = ($enemy->damage() + $locationLevel) * $enemy->danger;

            while ($charHp > 0 && $enemyHp > 0) {
                $enemyHp -= $character->damage();
                if ($enemyHp > 0) {
                    $reductionRatio = $character->defense() / ($character->defense() + 10 * $enemyDmg);
                    $reducedDmg = round($enemyDmg * (1 - $reductionRatio));

                    $charHp -= $reducedDmg;
                }
            }

            if ($charHp <= 0) {
                $charHp = 0;
                break;
            }
        }

        if ($charHp <= 0) {
            $character->setRegenerationTime(0);
            $character->reduceExperience($totalExperience);
            $character->setDelayToNextAction($totalExperience);
            $character->addLog('battle', "Поражение: {$enemiesStackSize} {$enemy->getTitle()}, потеряно {$totalExperience} оп");
            return redirect()->back();
        }

        $availableItems = $enemy->availableItems();
        $totalItems = count($availableItems) * $enemiesStackSize;

        $items = Item::generateItemsFromPool(
            $totalItems,
            $availableItems,
            $character->dropChance() + 30
        );
        // $items = Item::generateItems($totalItems, $availableItems, $character->dropChance() + 30);
        $transition->addItems($items);

        $resultItemsArray = [];

        foreach ($items as $item) {
            // $transition->addItem($item['id'], $item['stack']);
            $resultItemsArray[] = $item['stack'] . " " . Item::findOrFail($item['id'])->getTitle();
        }

        $resultString = "Победа: {$enemiesStackSize} {$enemy->getTitle()}, получено {$totalExperience} оп";
        $resultItemsString = implode(', ', $resultItemsArray);
        if ($resultItemsString) {
            $resultString .= ", {$resultItemsString}";
        }
        $character->addLog('battle', $resultString);

        $character->increaseExperience($totalExperience);
        $character->setRegenerationTime($charHp);
        $transition->removeEnemy($enemyId, $enemiesStackSize);

        return redirect()->back();
    }
}
