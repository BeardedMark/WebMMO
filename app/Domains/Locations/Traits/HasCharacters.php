<?php

namespace App\Domains\Locations\Traits;

use App\Domains\Characters\Models\Character;

trait HasCharacters
{
    public function characters()
    {
        return Character::whereHas('transition', function ($query) {
            $query->where('location_id', $this->id);
        })->orderByDesc('name')->get();
    }

    public function charactersOnline()
    {
        return $this->characters()->filter(fn($char) => $char->isOnline());
    }

    public function charactersCount(): int
    {
        return $this->characters()->count();
    }

    public function charactersOnlineCount(): int
    {
        return $this->charactersOnline()->count();
    }
}
