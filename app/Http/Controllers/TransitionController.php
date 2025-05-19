<?php

namespace App\Http\Controllers;

use App\Models\Transition;
use Illuminate\Http\Request;

use App\Models\Character;
use App\Models\Enemy;
use App\Models\Location;
use App\Models\Item;
use App\Models\Road;

use Illuminate\Support\Facades\Auth; //Auth::

class TransitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $character = Auth::user()->character;
        $location = $character->currentLocation();
        $transition = $character->latestTransition;

        if ($transition->hideout) {
            return view('db.hideouts.show', $transition->hideout);
        }

        return view('db.transitions.index', compact('character', 'location', 'transition'));
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
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
        ]);

        $character = Auth::user()->character;
        $fromLocation = $character->location;
        $toLocation = Location::findOrFail($request->location_id);

        if ($character->timeToNextAction() > 0) {
            return redirect()->back()->with('error', "Переход пока невозможен");
        }

        foreach ($character->availableRoads() as $road) {
            if (($road->from_location_id === $fromLocation->id && $road->to_location_id === $toLocation->id) ||
                ($road->from_location_id === $toLocation->id && $road->to_location_id === $fromLocation->id)
            ) {
                $chosenRoad = $road;
                break;
            }
        }
        if (!$chosenRoad && $fromLocation != $toLocation) {
            return redirect()->back()->with('error', "Нет доступной дороги для перехода в этом направлении");
        }
        if ($road->from_location_id === $fromLocation->id && !$road->is_open) {
            return redirect()->back()->with('error', "Дорога в этом направлении закрыта");
        }

        $loot = $this->generateContentForLocation($toLocation, $character);

        $transition = $character->allTransitions()->create([
            'location_id' => $toLocation->id,
            'enemies' => $loot['enemies'],
        ]);
        $transition->addItems($loot['items']);

        $delay = $chosenRoad->getDistance() + $toLocation->getSize() + $character->overWeight();
        $character->setDelayToNextAction($delay);
        $character->addLog('transitions', "Вход: {$toLocation->getTitle()}, потрачено {$delay} сек");

        return redirect()->route('transitions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transition $transition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transition $transition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transition $transition)
    {
        $request->validate([
            'hideout_id' => 'nullable|exists:hideouts,id',
        ]);

        $character = Auth::user()->character;
        $location = $transition->location;

        if ($character->timeToNextAction() > 0) {
            return redirect()->back()->with('error', "Переход пока невозможен");
        }

        $loot = $this->generateContentForLocation($location, $character);
        $transition->update([
            'items' => [],
            'enemies' => $loot['enemies'],
        ]);
        $transition->addItems($loot['items']);


        $delay = $location->getSize() + $character->overWeight();
        $character->setDelayToNextAction($delay);
        $character->addLog('transitions', "Переобход: {$location->getTitle()}, потрачено {$delay} сек");

        return redirect()->route('transitions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transition $transition)
    {
        //
    }

    protected function generateContentForLocation(Location $location, Character $character): array
    {
        $items = Item::generateItemsFromPool(
            $location->getSize(),
            $location->availableItems(),
            $character->dropChance()
        );

        $enemies = Enemy::generateEnemies(
            $location->getSize(),
            $location->availableEnemies(),
            $character->dropChance()
        );

        return [
            'items' => $items,
            'enemies' => $enemies,
        ];
    }
}
