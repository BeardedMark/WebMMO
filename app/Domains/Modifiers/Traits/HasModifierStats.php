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

    public function getResultValue(string $addCode, string $increaseCode): float
    {
        $add = $this->getModifierValueByCode($addCode);
        $increase = $this->getModifierValueByCode($increaseCode);

        return $add + ($add * $increase / 100);
    }

    // Attributes

    public function getAttributesColor(): array
    {
        $strength = $this->getStrength();
        $agility = $this->getAgility();
        $intelligence = $this->getIntelligence();

        $onePercent = 100 / max($strength, $agility, $intelligence);

        return  [
            'R' => 2.55 * ($strength * $onePercent),
            'G' => 2.55 * ($agility * $onePercent),
            'B' => 2.55 * ($intelligence * $onePercent)
        ];
    }

    public function getStrength(): float
    {
        $strength = $this->getLevel() + $this->getResultValue('add_strength', 'increase_strength');
        return floor($strength);
    }

    public function getAgility(): float
    {
        $agility = $this->getLevel() + $this->getResultValue('add_agility', 'increase_agility');
        return floor($agility);
    }

    public function getIntelligence(): float
    {
        $intelligence = $this->getLevel() + $this->getResultValue('add_intelligence', 'increase_intelligence');
        return floor($intelligence);
    }

    // Properties

    public function getViewRange()
    {
        return 100 + $this->getResultValue('add_view_range', 'increase_view_range');
    }

    public function maxWeight()
    {
        return 30 + $this->getStrength() + $this->getResultValue('add_weight', 'increase_weight');
    }

    public function overWeight()
    {
        $overWeight = $this->getTotalWeight() - $this->maxWeight();
        return $overWeight > 0 ? $overWeight : 0;
    }

    // Defense

    public function getDefence()
    {
        $defence = $this->getResultValue('add_defence', 'increase_defence');
        return floor($defence);
    }

    // Strength

    public function getDamage()
    {
        $damage = $this->getStrength() + $this->getResultValue('add_damage', 'increase_damage');
        return floor($damage);
    }

    public function getHealth()
    {
        $health = 10 + $this->getStrength() + $this->getResultValue('add_health', 'increase_health');
        return floor($health);
    }

    public function getRegen()
    {
        return 1 + $this->getResultValue('add_health_regen', 'increase_health_regen');
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

    public function getMoveSpeed(): float
    {
        $moveSpeed = 15 + $this->getResultValue('add_move_speed', 'increase_move_speed');
        $agility = $this->getAgility();

        $agilityBoost = $agility / ($agility + (10 * $moveSpeed));
        $moveSpeed = $moveSpeed + $moveSpeed * $agilityBoost;

        return number_format($moveSpeed, 2);
    }

    public function getAttackSpeed(): float
    {
        $attackSpeed = $this->getResultValue('add_attack_speed', 'increase_attack_speed');
        $agility = $this->getAgility();
        $boost = $agility + $attackSpeed;

        $speedBoost = $boost / ($boost + (10 * 1));
        $attackSpeed = 1 + 1 * $speedBoost;

        return number_format($attackSpeed, 2);
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
