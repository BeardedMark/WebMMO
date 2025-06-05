<?php

namespace App\Services;

use App\Models\Battle;
use App\Domains\Enemies\Instances\EnemyInstance;
use App\Domains\Characters\Models\Character;

class CombatService
{
    public static function fight($character, EnemyInstance $enemy): bool
    {
        $charAttack = $character->getDamage();
        $charHealth = $character->getCurrentHealth();
        $enemyAttack = $enemy->getDamage();
        $enemyHealth = $enemy->getHealth();

        while ($charHealth > 0 && $enemyHealth > 0) {
            $enemyHealth -= $charAttack;
            $character->addLog('CombatService.fight', "Вы наносите 💥{$charAttack} урона. У врага осталось ❤️{$enemyHealth}");

            if ($enemyHealth <= 0) break;

            $charHealth -= $enemyAttack;
            $character->addLog('CombatService.fight', "{$enemy->getModel()->getTitle()} наносит 💥{$enemyAttack} урона. У вас осталось ❤️{$charHealth}");
        }

        $character->setRegenerationTime($charHealth > 0 ? $charHealth : 0);

        if ($charHealth < 0) {
            // $character->setDelayToNextAction($charHealth * -1);
        }

        return $charHealth > 0;
    }

    public static function fightCharacterVsCharacter(Battle $battle, Character $a, Character $b): Character
    {
        $aName = $a->getTitle();
        $bName = $b->getTitle();

        $aAttack = $a->getDamage();
        $aHealth = $a->getCurrentHealth();

        $bAttack = $b->getDamage();
        $bHealth = $b->getCurrentHealth();

        $turn = 0;

        while ($aHealth > 0 && $bHealth > 0) {
            if ($turn % 2 === 0) {
                // A атакует B
                $bHealth -= $aAttack;
                $battle->addLog($aName, "Атакует наносит 💥{$aAttack} урона. У {$bName} осталось ❤️{$bHealth} здоровья");
            } else {
                // B атакует A
                $aHealth -= $bAttack;
                $battle->addLog($bName, "Атакует наносит 💥{$bAttack} урона. У {$aName} осталось ❤️{$aHealth} здоровья");
            }

            $turn++;
        }

        $a->setRegenerationTime($aHealth > 0 ? $aHealth : 0);
        $b->setRegenerationTime($bHealth > 0 ? $bHealth : 0);

        if ($aHealth < 0) {
            $a->setDelayToNextAction($aHealth * -1);
        } else {
            $b->setDelayToNextAction($bHealth * -1);
        }
        return $aHealth > 0 ? $a : $b;
    }
}
