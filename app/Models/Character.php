<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Hideout;
use App\Traits\HasItems;
use Illuminate\Database\Eloquent\SoftDeletes;


class Character extends Model
{
    use SoftDeletes;
    use HasItems;

    protected $fillable = [
        'name',
        'user_id',
        'status',
        'items'
    ];

    protected $casts = [
        'items' => 'array',
    ];

    // Values

    public function getTitle()
    {
        return $this->name;
    }

    public function getStatus()
    {
        return $this->status ?? ($this->timeToNextAction() > 0 ? 'В пути' : 'Отдыхает');
    }

    public function getLevel()
    {
        return count($this->visitedLocations());
    }

    public function getExpiriance()
    {
        return count($this->allTransitions()->get());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Transitions

    public function allTransitions()
    {
        return $this->hasMany(Transition::class);
    }

    public function latestTransitions($limit = 10)
    {
        return $this->hasMany(Transition::class)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function latestTransition()
    {
        return $this->hasOne(Transition::class)->latestOfMany();
    }

    public function timeToNextAction()
    {
        $transition = $this->latestTransition()->first();

        if (!$transition || !$transition->next_action_at) {
            return 0;
        }

        return max(0, now()->diffInSeconds($transition->next_action_at, false));
    }

    public function timeOnCurrentLocation()
    {
        $transition = $this->latestTransition()->first();

        if (!$transition || !$transition->created_at) {
            return null;
        }

        return $transition->created_at->diffInSeconds(now());
    }

    // Locations

    public function currentLocation()
    {
        $latestTransition = $this->latestTransition()->with('toLocation')->first();
        return $latestTransition?->toLocation;
    }

    public function availableLocations()
    {
        $currentLocation = $this->currentLocation();

        if ($currentLocation) {
            return $currentLocation->connectedLocations();
        } else {
            return Location::where('level', 0)->where('is_open', true)->get();
        }
    }

    public function visitedLocations()
    {
        return $this->hasMany(Transition::class)
            ->with('toLocation')
            ->get()
            ->pluck('toLocation')
            ->unique('id');
    }

    public function unvisitedLocations()
    {
        $visited = $this->visitedLocations()->pluck('id');

        $connected = Location::whereIn('id', function ($query) use ($visited) {
            $query->select('to_location_id')
                ->from('roads')
                ->whereIn('from_location_id', $visited)
                ->where('is_open', true)
                ->union(
                    \DB::table('roads')
                        ->select('from_location_id')
                        ->whereIn('to_location_id', $visited)
                        ->where('is_open', true)
                        ->where('is_one_way', false)
                );
        })
            ->whereNotIn('id', $visited)
            ->get();

        return $connected;
    }

    // Roads
    public function roadsToUnvisitedLocations()
    {
        $visitedLocations = $this->visitedLocations()->pluck('id');
        $unvisitedLocations = Location::whereNotIn('id', $visitedLocations)->pluck('id');

        return Road::whereIn('from_location_id', $visitedLocations)
            ->whereIn('to_location_id', $unvisitedLocations)
            ->orWhereIn('from_location_id', $unvisitedLocations)
            ->whereIn('to_location_id', $visitedLocations)
            ->get();
    }

    public function roadsToVisitedLocations()
    {
        $visitedLocations = $this->visitedLocations()->pluck('id');

        return Road::whereIn('from_location_id', $visitedLocations)
            ->whereIn('to_location_id', $visitedLocations)
            ->get();
    }

    public function availableRoads()
    {
        $current = $this->currentLocation();

        return Road::where(function ($query) use ($current) {
            $query->where('from_location_id', $current->id)
                ->orWhere('to_location_id', $current->id);
        })->get();
    }
}
