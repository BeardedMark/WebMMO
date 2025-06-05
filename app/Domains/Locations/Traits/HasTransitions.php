<?php

namespace App\Domains\Locations\Traits;

use App\Models\Transition;

trait HasTransitions
{
        public function transitionsFrom()
    {
        return $this->hasMany(Transition::class, 'from_location_code', 'code');
    }

    public function transitionsTo()
    {
        return $this->hasMany(Transition::class, 'to_location_code', 'code');
    }

    public function allTransitionsQuery()
    {
        return Transition::where(function ($query) {
            $query->where('from_location_code', $this->code)
                ->orWhere('to_location_code', $this->code);
        });
    }

    public function latestTransitions($limit = 20)
    {
        return $this->allTransitionsQuery()
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function hasRecentTransitions(): bool
    {
        return $this->allTransitionsQuery()
            ->where('created_at', '>=', now()->subDay())
            ->exists();
    }
}
