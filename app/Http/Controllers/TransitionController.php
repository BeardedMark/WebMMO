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
    public function index()
    {
        $currentCharacter = Auth::user()->character;
        $currentLocation = $currentCharacter->currentLocation();
        $currentTransition = $currentCharacter->latestTransition;

        if($currentTransition->hideout){
            return view('hideouts.show', $currentTransition->hideout);
        }

        return view('transitions.index', compact('currentCharacter', 'currentLocation', 'currentTransition'));
    }

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
            'hideout_id' => 'nullable|exists:hideouts,id',
        ]);

        $currentCharacter = Auth::user()->character;
        $fromLocation = $currentCharacter->currentLocation();
        $toLocation = Location::findOrFail($request->location_id);

        if ($currentCharacter->timeToNextAction() > 0) {
            return redirect()->back()->with('error', "Переход пока невозможен");
        }

        $chosenRoad = null;

        foreach ($currentCharacter->availableRoads() as $road) {
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

        $items = Item::generateItems($toLocation->getSize(), $toLocation->availableItems(), $currentCharacter->dropChance());
        $enemies = Enemy::generateEnemies($toLocation->getSize(), $toLocation->availableEnemies(), $currentCharacter->dropChance());

        $currentCharacter->allTransitions()->create([
            'location_id' => $toLocation->id,
            'items' => $items,
            'enemies' => $enemies,
        ]);


        $delay = (isset($chosenRoad) ? $chosenRoad->getDistance() : 0) + $toLocation->getSize() + $currentCharacter->overWeight();
        $currentCharacter->setDelayToNextAction($delay);

        if ($fromLocation == $toLocation) {
            $currentCharacter->addLog('transitions', 'Переобход: ' . $toLocation->getTitle());
        } else {
            $currentCharacter->addLog('transitions', 'Вход: ' . $toLocation->getTitle());
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transition $transition)
    {
        //
    }
}
