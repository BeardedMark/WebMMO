<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::where('is_open', true)->orderBy('level', 'asc')->get();
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'level' => 'required|integer|min:0',
            'size' => 'required|integer|min:1',
            'is_open' => 'boolean',
            'x' => 'required|integer',
            'y' => 'required|integer',
        ]);

        Location::create($data);

        return redirect()->route('locations.index')->with('success', 'Локация создана');
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'level' => 'required|integer|min:0',
            'size' => 'required|integer|min:1',
            'is_open' => 'boolean',
            'x' => 'required|integer',
            'y' => 'required|integer',
        ]);

        $location->update($data);

        return redirect()->route('locations.index')->with('success', 'Локация обновлена');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Локация удалена');
    }
}
