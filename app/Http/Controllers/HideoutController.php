<?php

namespace App\Http\Controllers;

use App\Models\Hideout;
use Illuminate\Http\Request;

class HideoutController extends Controller
{
    public function index()
    {
        $hideouts = Hideout::with('user', 'location')->get();
        return view('hideouts.index', compact('hideouts'));
    }

    public function create()
    {
        $location = auth()->user()->character->currentLocation();

        return view('hideouts.create', compact('location'));
    }

    public function show(Hideout $hideout)
    {
        $location = auth()->user()->character->currentLocation();
        return view('hideouts.show', compact('hideout', 'location'));
    }

    public function edit(Hideout $location)
    {
        return view('hideouts.edit', compact('location'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $user = auth()->user();

    if (!$user->checkCharacter()) {
        return redirect()->back()->with('error', 'У вас нет активного персонажа.');
    }

    $data['user_id'] = $user->id;
    $data['location_id'] = $user->character->location_id;

    $hideout = Hideout::create($data);

    return redirect()->route('hideouts.show', $hideout);
}


    public function update(Request $request, Hideout $hideout)
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'level' => 'integer|min:0',
            'items' => 'nullable|array',
        ]);

        $hideout->update($data);

        return redirect()->route('hideouts.show', $hideout);
    }

    public function destroy(Hideout $hideout)
    {
        $hideout->delete();

        return redirect()->route('hideouts.index');
    }
}
