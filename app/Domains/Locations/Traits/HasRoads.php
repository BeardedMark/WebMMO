<?php

namespace App\Domains\Locations\Traits;

use App\Models\Road;

trait HasRoads
{
    public function outgoingRoads()
    {
        return $this->hasMany(Road::class, 'from_location_code', 'code');
    }

    public function incomingRoads()
    {
        return $this->hasMany(Road::class, 'to_location_code', 'code');
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
}
