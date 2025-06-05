<?php

namespace App\Domains\Locations\Traits;

use App\Models\Battle;

trait HasBattles
{
    public function battles()
    {
        return $this->hasMany(Battle::class, 'location_id');
    }

    public function openBattles()
    {
        return $this->battles()->whereNull('winner_id')->get();
    }

    public function finishedBattles()
    {
        return $this->battles()->whereNotNull('winner_id')->get();
    }

    public function hasOpenBattles(): bool
    {
        return $this->openBattles()->isNotEmpty();
    }
}
