<?php

namespace App\Http\Controllers;

use App\Models\Transition;
use Illuminate\Http\Request;

use App\Domains\Characters\Models\Character;
use App\Domains\Enemies\Models\Enemy;
use App\Domains\Locations\Models\Location;
use App\Domains\Items\Models\Item;
use App\Services\MovementService;

use Illuminate\Support\Facades\Auth;

class TransitionController extends Controller
{
    public function index(Request $request)
    {
        $character = $request->user()->currentCharacter();
        $location = $character->currentLocation();
        $transition = $character->latestTransition;

        return view('db.transitions.index', compact('character', 'location', 'transition'));
    }

    public function create() {}

    public function store(Request $request, MovementService $movement)
    {
        $request->validate(['location_id' => 'required|exists:locations,id']);

        $character = Auth::user()->currentCharacter();
        $location = Location::findOrFail($request->location_id);

        $transition = $movement->moveTo($character, $location);

        if (!$transition) {
            $character->addLog('TransitionController.store', "Нельзя перейти в локацию {$location->getTitle()}");
            return back();
        }

        return redirect()->route('transitions.index');
    }

    public function show(Transition $transition)
    {
        $character = Auth::user()->currentCharacter();
        $location = $character->currentLocation();
        $transition = $character->transition;

        return view('db.transitions.show', compact('character', 'location', 'transition'));
    }

    public function edit(Transition $transition) {}

    public function update(Request $request, Transition $transition, MovementService $movement)
    {
        $character = Auth::user()->currentCharacter();

        if (!$character->isAvailable()) {
            $character->addLog('TransitionController.update', "Слишком рано для переобхода");
            return back();
        }

        $movement->refreshLocation($character, $transition);

        return redirect()->route('transitions.show', $transition);
    }

    public function destroy(Transition $transition) {}
}
