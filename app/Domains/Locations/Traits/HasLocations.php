<?php

namespace App\Domains\Locations\Traits;

trait HasLocations
{
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
}
