<?php

namespace App\Domains\Characters\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Domains\Characters\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->characters()->update(['is_current' => false]);

        $character = Character::create([
            'code' => $data['name'],
            'name' => $data['name'],
            'user_id' => $user->id,
            'image' => 'default.png',
            'is_current' => true
        ]);

        // $user->character_id = $character->id;
        // $user->save();

        $spawnLocation = $character->availableLocations()->random();

        Transition::create([
            'character_id' => $character->id,
            'location_id' => $spawnLocation->id,
        ]);

        $character->addLog('CharacterController.store', "Персонаж создан");
        return redirect()->route('transitions.index');
    }


    public function show(Character $character)
    {
        return view('db.characters.show', compact('character'));
    }

    public function edit(Character $character, Request $request)
    {
        if ($request->user()->currentCharacter()?->id !== $character->id) return back();

        $files = Storage::disk('public')->files('images/characters');
        $avatars = collect($files)->map(function ($file) {
            return basename($file);
        });

        return view('db.characters.edit', compact('character', 'avatars'));
    }

    public function update(Request $request, Character $character)
    {
        if ($request->user()->currentCharacter() != $character) return back();

        $data = $request->validate([
            'image' => 'required|string',
            'description' => 'nullable|string|max:150',
            'content' => 'nullable|string|max:3000',
        ]);

        $character->update([
            'image' => $data['image'],
            'description' => $data['description'] ?? '',
            'content' => $data['content'] ?? '',
        ]);

        return redirect()->route('characters.show', $character)->with('success', 'Персонаж обновлён');
    }


    public function destroy(Character $character) {}

    public function inventory(Request $request)
    {
        $character = $request->user()->currentCharacter();
        return view('db.characters.inventory', compact('character'));
    }

    public function craft()
    {
        $character = Auth::user()->currentCharacter();
        return view('db.characters.craft', compact('character'));
    }

    public function select()
    {
        $user = Auth::user();
        return view('db.characters.select', compact('user'));
    }

    public function selected(Character $character)
    {
        $user = $character->user;

        $user->characters()->update(['is_current' => false]);

        $character->is_current = true;
        $character->save();

        return redirect()->route('transitions.index');
    }


    // API

    public function card(Character $character)
    {
        $user = Auth::user();
        $character = $user->character;

        return view('db.characters.frames.card', compact('character'));
    }

    public function values()
    {
        $character = Auth::user()->currentCharacter();

        return response()->json([
            'health_percent' => $character->getHealthPercent(),
            'level_percent' => $character->getLevelPercent(),
        ]);
    }
}
