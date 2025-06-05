<?php

namespace App\Domains\Characters\Traits;

use App\Models\Transition;
use App\Domains\Locations\Models\Location;
use App\Models\Road;

trait HasMovement
{
    // === ТРАНЗИЦИИ ===

    public function allTransitions()
    {
        return $this->hasMany(Transition::class);
    }

    public function latestTransitions($limit = 10)
    {
        return $this->allTransitions()
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function transition()
    {
        return $this->hasOne(Transition::class)->latestOfMany();
    }

    public function timeOnCurrentLocation()
    {
        $transition = $this->transition()->first();
        return $transition?->created_at?->diffInSeconds(now());
    }

    // === ТЕКУЩАЯ ЛОКАЦИЯ ===

    public function currentLocation()
    {
        return $this->transition?->location;
    }

    public function location()
    {
        return $this->transition->location();
    }

    // === ДОСТУПНЫЕ ДОРОГИ ===

    public function availableRoads()
    {
        $current = $this->currentLocation();

        if (!$current || !$current->is_open) {
            return collect();
        }

        return Road::where('is_open', true)
            ->where(function ($query) use ($current) {
                $query->where('from_location_code', $current->code)
                      ->orWhere(function ($q) use ($current) {
                          $q->where('to_location_code', $current->code)
                            ->where('is_one_way', false);
                      });
            })
            ->get();
    }

    // === ДОСТУПНЫЕ ЛОКАЦИИ ===

    public function availableLocations()
    {
        $current = $this->currentLocation();

        if (!$current || !$current->is_open) {
            return Location::where('level', 1)->where('is_open', true)->get();
        }

        return $this->availableRoads()->map(function ($road) use ($current) {
            return $road->from_location_code === $current->code
                ? $road->toLocation
                : $road->fromLocation;
        })->filter(fn($loc) => $loc?->is_open)->unique('code')->values();
    }

    // === ПОСЕЩЕННЫЕ / НЕПОСЕЩЕННЫЕ ===

    public function visitedLocations()
    {
        return $this->allTransitions()
            ->with('location')
            ->get()
            ->pluck('location')
            ->filter(fn($loc) => $loc)
            ->unique('code');
    }

    public function unvisitedLocations()
    {
        $visited = $this->visitedLocations()->pluck('code');

        return Location::whereNotIn('code', $visited)
            ->where('is_open', true)
            ->whereIn('code', function ($query) use ($visited) {
                $query->select('to_location_code')
                      ->from('roads')
                      ->where('is_open', true)
                      ->whereIn('from_location_code', $visited)
                      ->union(
                          Road::select('from_location_code')
                              ->where('is_open', true)
                              ->whereIn('to_location_code', $visited)
                              ->where('is_one_way', false)
                      );
            })->get();
    }

    // === ДОРОГИ К НЕПОСЕЩЕННЫМ / ПОСЕЩЕННЫМ ===

    public function roadsToUnvisitedLocations()
    {
        $visited = $this->visitedLocations()->pluck('code');
        $unvisited = Location::whereNotIn('code', $visited)
            ->where('is_open', true)
            ->pluck('code');

        return Road::where('is_open', true)
            ->where(function ($query) use ($visited, $unvisited) {
                $query->whereIn('from_location_code', $visited)
                      ->whereIn('to_location_code', $unvisited);
            })
            ->orWhere(function ($query) use ($visited, $unvisited) {
                $query->whereIn('from_location_code', $unvisited)
                      ->whereIn('to_location_code', $visited)
                      ->where('is_one_way', false);
            })
            ->get();
    }

    public function roadsToVisitedLocations()
    {
        $visited = $this->visitedLocations()->pluck('code');

        return Road::where('is_open', true)
            ->whereIn('from_location_code', $visited)
            ->whereIn('to_location_code', $visited)
            ->get();
    }
}
