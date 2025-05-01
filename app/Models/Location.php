<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'level',
        'size',
        'is_open',
        'x',
        'y'
    ];

    // Values

    public function getTitle()
    {
        return $this->name;
    }

    public function getImageUrl()
    {
        return asset('storage/img/locations/' . $this->image ?? 'default.jpg');
    }

    public function getSoundUrl()
    {
        return asset('storage/sounds/locations/' . $this->sound ?? '');
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getSize()
    {
        return count($this->availableRoads()) + $this->level + 5;
    }

    // Items

    public function availableItems()
    {
        return Item::where(function ($query) {
            $query->whereNull('min_level')
                ->orWhere('min_level', '<=', $this->level);
        })
            ->where(function ($query) {
                $query->whereNull('max_level')
                    ->orWhere('max_level', '>=', $this->level);
            })
            ->get();
    }


    // Roads

    public function outgoingRoads()
    {
        return $this->hasMany(Road::class, 'from_location_id');
    }

    public function incomingRoads()
    {
        return $this->hasMany(Road::class, 'to_location_id');
    }

    public function availableRoads()
    {
        $outgoing = $this->outgoingRoads()
            ->where('is_open', true)
            ->get();

        $incoming = $this->incomingRoads()
            ->where('is_open', true)
            ->where('is_one_way', false)
            ->get();

        return $outgoing->merge($incoming);
    }

    // Transitions

    public function incomingTransitions()
    {
        return Transition::where('to_location_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function outgoingTransitions()
    {
        return Transition::where('from_location_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function allTransitions()
    {
        return Transition::where(function ($query) {
            $query->where('from_location_id', $this->id)
                ->orWhere('to_location_id', $this->id);
        })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Locations

    public function connectedLocations()
    {
        $outgoing = $this->outgoingRoads()
            ->where('is_open', true)
            ->with('toLocation')
            ->get()
            ->map(fn($road) => $road->toLocation);

        $incoming = $this->incomingRoads()
            ->where('is_open', true)
            ->where('is_one_way', false)
            ->with('fromLocation')
            ->get()
            ->map(fn($road) => $road->fromLocation);

        return $outgoing->merge($incoming);
    }

    // Characters

    public function charactersOnLocation()
    {
        return Character::whereHas('latestTransition', function ($query) {
            $query->where('to_location_id', $this->id);
        })->get();
    }
}
