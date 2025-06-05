<?php

namespace App\Domains\Modifiers\Traits;

trait HasModifierStats
{
    // Voids

    public function getModifierValueByCode(string $code): float
    {
        $modifiers = $this->getModifierStats();

        return optional($modifiers->firstWhere('code', $code))->getValue() ?? 0;
    }

    public function getResultValue(string $addCode, string $increaseCode, float $default = 0): float
    {
        $add = $this->getModifierValueByCode($addCode);
        $increase = $this->getModifierValueByCode($increaseCode);

        return $default + $add + ($add * $increase / 100);
    }

    // Attributes

    public function getStrength(): float
    {
        return  $this->getResultValue('add_strength', 'increase_strength', $this->getLevel());
    }

    public function getAgility(): float
    {
        return $this->getResultValue('add_agility', 'increase_agility', $this->getLevel());
    }

    public function getIntelligence(): float
    {
        return $this->getResultValue('add_intelligence', 'increase_intelligence', $this->getLevel());
    }

    // Properties

    public function getViewRange()
    {
        return $this->getResultValue('add_view_range', 'increase_view_range', 100);
    }

    public function maxWeight()
    {
        return $this->getResultValue('add_weight', 'increase_weight', 100) + $this->getStrength();
    }

    public function overWeight()
    {
        $overWeight = $this->getTotalWeight() - $this->maxWeight();
        return $overWeight > 0 ? $overWeight : 0;
    }

    // Defense

    public function getDefence()
    {
        return $this->getResultValue('add_defence', 'increase_defence');
    }

    // Strength

    public function getDamage()
    {
        return $this->getResultValue('add_damage', 'increase_damage', 1) + $this->getStrength();
    }

    public function getHealth()
    {
        return $this->getResultValue('add_health', 'increase_health', 10) + $this->getStrength();
    }

    public function getRegen()
    {
        return $this->getResultValue('add_health_regen', 'increase_health_regen', 1);
    }

    public function setRegenerationTime(int $currentHealth): void
    {
        $maxHealth = $this->getHealth();
        $regenPerSecond = $this->getRegen();

        $missingHealth = max(0, $maxHealth - $currentHealth);

        if ($regenPerSecond > 0 && $missingHealth > 0) {
            $secondsToFull = ceil($missingHealth / $regenPerSecond);
            $this->regenerated_at = now()->addSeconds($secondsToFull);
        } else {
            $this->regenerated_at = now();
        }

        $this->save();
    }

    public function getCurrentHealth(): int
    {
        $maxHealth = $this->getHealth();
        $regenPerSecond = $this->getRegen();
        $regeneratedAt = $this->regenerated_at ?? now();

        // Если регенерация отключена или уже полностью восстановился
        if ($regenPerSecond === 0 || now()->gte($regeneratedAt)) {
            return $maxHealth;
        }

        // Сколько секунд осталось до полного восстановления
        $secondsRemaining = now()->diffInSeconds($regeneratedAt, false);

        // Сколько здоровья ещё не восстановлено
        $missingHealth = $secondsRemaining * $regenPerSecond;

        // Текущее здоровье = максимум - то, что ещё не восстановлено
        $currentHealth = max(0, $maxHealth - $missingHealth);

        return (int) $currentHealth;
    }


    public function getHealthPercent(): int
    {
        $currentHealth = $this->getCurrentHealth();
        $maxHealth = $this->getHealth();

        if ($maxHealth === 0) {
            return 0;
        }

        return floor(($currentHealth / $maxHealth) * 100);
    }

    // Agility

    public function getSpeed()
    {
        return ($this->getAgility()) / 10;
    }

    public function getAccuracy()
    {
        return ($this->getAgility()) / 10;
    }

    // Intelligence

    public function getLuck()
    {
        return $this->getIntelligence() / 10;
    }

    public function critChance()
    {
        return $this->getIntelligence() / 10;
    }

    public function critDamage()
    {
        return $this->getIntelligence();
    }

    public function dropChanceBonus()
    {
        return $this->getIntelligence() / 10;
    }
}
