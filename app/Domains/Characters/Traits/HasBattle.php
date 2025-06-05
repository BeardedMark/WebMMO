<?php

namespace App\Domains\Characters\Traits;

use App\Models\Battle;

trait HasBattle
{
    /**
     * Текстовый статус персонажа в контексте боёв.
     */
    public function getBattleStatus(): ?string
    {
        if ($this->currentBattle()) {
            return 'В бою';
        }

        if ($this->openBattle()) {
            return 'Ожидание боя';
        }

        return 'Не в бою';
    }

    /**
     * Проверка: участвует ли персонаж в каком-либо бою (открытом или активном).
     */
    public function inBattle(): bool
    {
        return $this->currentBattle() !== null || $this->openBattle() !== null;
    }

    /**
     * Получить активный бой, где участвует персонаж (уже есть противник).
     */
    public function currentBattle(): ?Battle
    {
        return Battle::whereNull('winner_id')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('creator_id', $this->id);
                })->orWhere(function ($q) {
                    $q->where('opponent_id', $this->id);
                });
            })
            ->first();
    }

    /**
     * Получить открытый бой, созданный персонажем (без оппонента).
     */
    public function openBattle(): ?Battle
    {
        return Battle::where('creator_id', $this->id)
            ->whereNull('opponent_id')
            ->whereNull('winner_id')
            ->first();
    }

    /**
     * Получить завершённые бои (где есть победитель).
     */
    public function finishedBattles()
    {
        return Battle::whereNotNull('winner_id')
            ->where(function ($query) {
                $query->where('creator_id', $this->id)
                      ->orWhere('opponent_id', $this->id);
            });
    }

    /**
     * Получить список победных боёв.
     */
    public function wonBattles()
    {
        return $this->finishedBattles()
            ->where('winner_id', $this->id);
    }

    /**
     * Получить список проигранных боёв.
     */
    public function lostBattles()
    {
        return $this->finishedBattles()
            ->where('winner_id', '!=', $this->id);
    }
}
