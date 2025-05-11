<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

use App\Models\Transition;
use Illuminate\Support\Facades\Auth; //Auth::

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::all();
        return view('characters.index', compact('characters'));
    }

    public function create()
    {
        return view('characters.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:characters,name|min:5|max:255'
        ]);

        $character = new Character();
        $character->name = $data['name'];
        $character->user_id = Auth::id();
        $character->items = $data['items'] ?? [];
        $character->save();

        $user = $character->user;
        $user->character_id = $character->id;
        $user->save();

        $spawnLocation = $character->availableLocations()->random();

        Transition::create([
            'character_id' => $character->id,
            'location_id' => $spawnLocation->id,
        ]);

        return redirect()->route('transitions.index');
    }

    public function show(Character $character)
    {
        return view('characters.show', compact('character'));
    }

    public function edit(Character $character)
    {
        return view('characters.edit', compact('character'));
    }

    public function update(Request $request, Character $character)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $character->name = $data['name'];
        $character->save();

        return redirect()->route('characters.index')->with('success', 'Персонаж обновлён');
    }

    public function destroy(Character $character)
    {
        $character->delete();
        return redirect()->route('characters.index')->with('success', 'Персонаж удалён');
    }

    public function select()
    {
        $user = Auth::user();
        return view('characters.select', compact('user'));
    }

    public function selected(Character $character)
    {
        $user = $character->user;
        $user->character_id = $character->id;
        $user->save();

        return redirect()->route('transitions.index')->with('success', 'Персонаж выбран');
    }

    public function card(Character $character)
    {
        $user = Auth::user();
        $character = $user->character;

        return view('characters.components.card', compact('character'));
    }

    public function inventory()
    {
        $currentCharacter = Auth::user()->character;
        $currentLocation = $currentCharacter->currentLocation();
        $currentTransition = $currentCharacter->latestTransition;

        return view('characters.inventory', compact('currentCharacter', 'currentLocation', 'currentTransition'));
    }

    public function craft()
    {
        $currentCharacter = Auth::user()->character;
        $currentLocation = $currentCharacter->currentLocation();
        $currentTransition = $currentCharacter->latestTransition;

        return view('characters.craft', compact('currentCharacter', 'currentLocation', 'currentTransition'));
    }

    public function disassemble()
    {
        $currentCharacter = Auth::user()->character;
        $currentLocation = $currentCharacter->currentLocation();
        $currentTransition = $currentCharacter->latestTransition;

        return view('characters.disassemble', compact('currentCharacter', 'currentLocation', 'currentTransition'));
    }
}
