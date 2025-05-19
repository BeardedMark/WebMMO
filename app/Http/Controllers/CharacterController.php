<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

use App\Models\Transition;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::all();
        return view('db.characters.index', compact('characters'));
    }

    public function create()
    {
        return view('db.characters.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:characters,name|min:5|max:20'
        ]);

        $user = Auth::user();

        $character = new Character();
        $character->name = $data['name'];
        $character->user_id = $user->id;
        $character->save();

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
        return view('db.characters.show', compact('character'));
    }

    public function edit(Character $character)
    {

    }

    public function update(Request $request, Character $character)
    {

    }

    public function destroy(Character $character)
    {
        $character->delete();
        return redirect()->route('characters.index');
    }

    public function select()
    {
        $user = Auth::user();
        return view('db.characters.select', compact('user'));
    }

    public function selected(Character $character)
    {
        $user = $character->user;
        $user->character_id = $character->id;
        $user->save();

        return redirect()->route('transitions.index');
    }

    public function card(Character $character)
    {
        $user = Auth::user();
        $character = $user->character;

        return view('db.characters.frames.card', compact('character'));
    }

    public function inventory()
    {
        $character = Auth::user()->character;
        return view('db.characters.inventory', compact('character'));
    }

    public function craft()
    {
        $character = Auth::user()->character;
        return view('db.characters.craft', compact('character'));
    }
}
