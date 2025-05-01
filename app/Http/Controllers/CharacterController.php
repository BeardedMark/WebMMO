<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

use App\Models\Transition;

class CharacterController extends Controller
{
    public function index()
    {
        $allCharacters = Character::all();
        return view('characters.index', compact('allCharacters'));
    }

    public function create()
    {
        return view('characters.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $character = new Character();
        $character->name = $data['name'];
        $character->user_id = auth()->id();
        $character->items = $data['items'] ?? [];
        $character->save();

        $user = auth()->user();
        $user->character_id = $character->id;
        $user->save();

        $spawnLocation = $character->availableLocations()->random();

        Transition::create([
            'character_id' => $character->id,
            'to_location_id' => $spawnLocation->id,
            'next_action_at' => now()->addSeconds(($spawnLocation->getSize())),
        ]);

        return redirect()->route('transitions.index')->with('success', 'Персонаж создан');
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
            'items' => 'nullable|array',
        ]);

        $character->name = $data['name'];
        $character->items = $data['items'] ?? $character->items;
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
        $user = auth()->user();
        return view('characters.select', compact('user'));
    }

    public function selected(Character $character)
    {
        $user = auth()->user();
        $user->character_id = $character->id;
        $user->save();

        return redirect()->route('transitions.index')->with('success', 'Персонаж выбран');
    }
}
