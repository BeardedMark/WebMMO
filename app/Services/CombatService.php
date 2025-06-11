<?php

namespace App\Services;

use App\Models\Battle;
use App\Domains\Enemies\Instances\EnemyInstance;
use App\Domains\Characters\Models\Character;

class CombatService
{
    public static function autoFightVsBot($character, EnemyInstance $enemy, bool $isAttack = false): bool
    {
        $charDamage = $character->getDamage();
        $charHealth = $character->getCurrentHealth();
        $charDefence = $character->getDefence();
        $charAttackSpeed = $character->getAttackSpeed();

        $enemyDamage = $enemy->getDamage();
        $enemyHealth = $enemy->getHealth();
        $enemyDefence = $enemy->getDefence();
        $enemyAttackSpeed = $enemy->getAttackSpeed();

        $charDamageReduction = $charDefence / ($charDefence + (10 * $enemyDamage));
        $enemyDamageReduction = $enemyDefence / ($enemyDefence + (10 * $charDamage));
        $charAttack = round($charDamage - $charDamage * $enemyDamageReduction);
        $enemyAttack = round($enemyDamage - $enemyDamage * $charDamageReduction);

        $minAttackSpeed = min($charAttackSpeed, $enemyAttackSpeed);
        $charAttacks = $charAttackSpeed / $minAttackSpeed;
        $enemyAttacks = $enemyAttackSpeed / $minAttackSpeed;

        $charExtraAttacksChance = (int) floor(($charAttacks - 1) * 100);
        $enemyExtraAttacksChance = (int) floor(($enemyAttacks - 1) * 100);

        $charAttacks = (int) floor($charAttacks);
        $enemyAttacks = (int) floor($enemyAttacks);

        // dd($charAttackSpeed, $enemyAttackSpeed, $minAttackSpeed, $charAttacks, $enemyAttacks, $charExtraAttacksChance, $enemyExtraAttacksChance);

        if ($isAttack) {
            for ($i = 0; $i < $enemyAttacks; $i++) {
                $charHealth -= $enemyAttack;
                $character->addLog('CombatService.autoFightVsBot', "{$enemy->getModel()->getTitle()} наносит 💥{$enemyAttack} урона. У вас осталось ❤️{$charHealth}");
            }

            if (rand(0, 100) < $enemyExtraAttacksChance) {
                $charHealth -= $enemyAttack;
                $character->addLog('CombatService.autoFightVsBot', "С шансом {$enemyExtraAttacksChance}, {$enemy->getModel()->getTitle()} наносит дополнительно 💥{$enemyAttack} урона. У вас осталось ❤️{$charHealth}");
            }
        }

        while ($charHealth > 0 && $enemyHealth > 0) {
            for ($i = 0; $i < $charAttacks; $i++) {
                $enemyHealth -= $charAttack;
                $character->addLog('CombatService.autoFightVsBot', "Вы наносите 💥{$charAttack} урона. У врага осталось ❤️{$enemyHealth}");
            }

            if (rand(0, 100) < $charExtraAttacksChance) {
                $enemyHealth -= $charAttack;
                $character->addLog('CombatService.autoFightVsBot', "С шансом {$charExtraAttacksChance}, вы наносите дополнительно 💥{$charAttack} урона. У врага осталось ❤️{$enemyHealth}");
            }

            if ($enemyHealth <= 0) break;

            for ($i = 0; $i < $enemyAttacks; $i++) {
                $charHealth -= $enemyAttack;
                $character->addLog('CombatService.autoFightVsBot', "{$enemy->getModel()->getTitle()} наносит 💥{$enemyAttack} урона. У вас осталось ❤️{$charHealth}");
            }

            if (rand(0, 100) < $enemyExtraAttacksChance) {
                $charHealth -= $enemyAttack;
                $character->addLog('CombatService.autoFightVsBot', "С шансом {$enemyExtraAttacksChance}, {$enemy->getModel()->getTitle()} наносит дополнительно 💥{$enemyAttack} урона. У вас осталось ❤️{$charHealth}");
            }
        }

        $character->setRegenerationTime($charHealth > 0 ? $charHealth : 0);

        if ($charHealth < 0) {
            $character->setDelayToNextAction($charHealth * -10);
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
