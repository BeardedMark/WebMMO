<?php

namespace App\Domains\Locations\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Domains\Locations\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::where('is_open', true)
            ->orderBy('level', 'asc')
            ->get();

        return view('db.locations.index', compact('locations'));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(Location $location)
    {
        return view('db.locations.show', compact('location'));
    }

    public function edit(Location $location) {}

    public function update(Request $request, Location $location) {}

    public function destroy(Location $location) {}
}
