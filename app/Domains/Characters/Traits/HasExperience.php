<?php

namespace App\Domains\Characters\Traits;

trait HasExperience
{
    private float $growthRate = 2.5;

    public function getExperience()
    {
        return $this->experience;
    }

    public function getLevel()
    {
        $level = 1;
        $expToNext = 10;
        $experience = $this->getExperience();

        while ($experience >= $expToNext) {
            $experience -= $expToNext;
            $level++;
            $expToNext = intval($expToNext * $this->growthRate);
        }

        return $level;
    }

    public function getLevelPercent()
    {
        $level = $this->getLevel();
        $exp = $this->getExperience();

        $expToCurrentLevel = $this->getTotalExpToLevel($level);
        $expToPreviousLevel = $this->getTotalExpToLevel($level - 1);

        $currentExp = $exp - $expToPreviousLevel;
        $levelExp = $expToCurrentLevel - $expToPreviousLevel;

        return $levelExp > 0 ? floor(($currentExp / $levelExp) * 100) : 100;
    }

    public function experienceToCurrentLevel()
    {
        return $this->getTotalExpToLevel($this->getLevel() - 1);
    }

    public function experienceToNextLevel()
    {
        return $this->getTotalExpToLevel($this->getLevel());
    }

    public function getTotalExpToLevel($level)
    {
        $exp = 0;
        $expToNext = 10;

        for ($i = 1; $i <= $level; $i++) {
            $exp += $expToNext;
            $expToNext = intval($expToNext * $this->growthRate);
        }

        return $exp;
    }

    public function increaseExperience(int $experience): void
    {
        $this->increment('experience', $experience);
    }

    public function reduceExperience(int $experience): void
    {
        $minExp = $this->experienceToCurrentLevel();
        $newExp = $this->getExperience() - $experience;

        $this->experience = max($minExp, $newExp);
        $this->save();
    }
}
