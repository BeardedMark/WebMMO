<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;
use App\Domains\Characters\Models\Character;
use App\Domains\Locations\Models\Location;

class Battle extends Model
{
    use HasLogs;

    protected $fillable = [
        'location_id',
        'creator_id',
        'opponent_id',
        'winner_id',
        'type',
        'logs'
    ];

    protected $casts = [
        'logs' => 'array',
    ];

    protected static $types = [
        'normal'  => 'Обычный',
        'rating'  => 'Рейтинговый',
        'brutal'  => 'Жестокий',
        'siege'   => 'Осадный',
    ];

    public static function getTypes(): array
    {
        return self::$types;
    }

    public function getTitle(): string
    {
        return $this->getTypes()[$this->type];
    }

    public function getStatus(): string
    {
        return $this->getWinner() ? 'Закончен' : ($this->hasOpponent() ? 'Начинается' : 'Создан');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function getCreator(): Character
    {
        return $this->belongsTo(Character::class, 'creator_id')->first();
    }

    public function getOpponent(): ?Character
    {
        return $this->belongsTo(Character::class, 'opponent_id')->first();
    }

    public function hasOpponent(): bool
    {
        return $this->getOpponent() !== null;
    }

    public function getWinner(): ?Character
    {
        return $this->belongsTo(Character::class, 'winner_id')->first();
    }

    public function hasWinner(): bool
    {
        return $this->getWinner() !== null;
    }

    public function isRating(): bool
    {
        return $this->is_rating ?? false;
    }

    public function isMortal(): bool
    {
        return $this->is_mortal ?? false;
    }
}
