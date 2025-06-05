<?php

namespace App\Services;

use App\Domains\Items\Models\Item;

class RequirementService
{
    /**
     * Проверяет список условий для объекта
     */
    public static function check($character, array $requirements): bool
    {
        foreach ($requirements as $req) {
            switch ($req['type']) {
                case 'has_item':
                    if (!$character->getItems()->firstWhere('code', $req['code'])) {
                        $character->addLog('RequirementService', "Для взаимодействия требуется {$req['code']}");
                        return false;
                    }
                    break;

                case 'has_attribute':
                    if (($character->{$req['attr']} ?? 0) < ($req['value'] ?? 0)) return false;
                    break;

                case 'location_has':
                    if (!$character->location->objects->contains('code', $req['object'])) return false;
                    break;

                case 'unlocked_craft':
                    if (!in_array($req['code'], $character->unlocked_crafts ?? [])) return false;
                    break;

                case 'repeat_count':
                    $count = $character->craft_history[$req['code']] ?? 0;
                    if ($count < ($req['count'] ?? 1)) return false;
                    break;

                default:
                    return false; // неизвестный тип
            }
        }

        return true;
    }

    /**
     * Возвращает список неудовлетворённых требований (для UI)
     */
    public static function unmet($character, array $requirements): array
    {
        $missing = [];

        foreach ($requirements as $req) {
            switch ($req['type']) {
                case 'has_item':
                    if (!$character->getItems()->firstWhere('code', $req['code'])) {
                        $missing[] = 'Нужен предмет: ' . $req['code'];
                    }
                    break;

                case 'has_attribute':
                    if (($character->{$req['attr']} ?? 0) < ($req['value'] ?? 0)) {
                        $missing[] = 'Недостаточно ' . $req['attr'];
                    }
                    break;

                case 'has_object':
                    if (!$character->location->objects->contains('code', $req['code'])) {
                        $missing[] = 'На локации должен быть: ' . $req['code'];
                    }
                    break;

                case 'unlocked_craft':
                    if (!in_array($req['code'], $character->unlocked_crafts ?? [])) {
                        $missing[] = 'Не изучен рецепт: ' . $req['code'];
                    }
                    break;

                case 'repeat_count':
                    $count = $character->craft_history[$req['code']] ?? 0;
                    if ($count < ($req['count'] ?? 1)) {
                        $missing[] = 'Нужно разобрать ' . $req['count'] . '× ' . $req['code'];
                    }
                    break;
            }
        }

        return $missing;
    }
}
