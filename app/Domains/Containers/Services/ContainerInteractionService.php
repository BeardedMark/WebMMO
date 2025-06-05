<?php

namespace App\Services;

use App\Domains\Items\Factories\ItemFactory;
use App\Services\Instances\ContainerInstance;
use App\Services\RequirementService;

class ContainerInteractionService
{
    /**
     * Взаимодействие с объектом и перенос лута в целевой контейнер
     */
    public static function interact($character, ContainerInstance $container, $container): bool
    {
        // Проверка требований
        if (!RequirementService::check($character, $container->getRequirements())) {
            return false;
        }

        // Генерация предметов
        $items = collect();
        foreach ($container->getItems() as $data) {
            $item = ItemFactory::makeByCode($data['code'], $data['stack'] ?? 1);
            if ($item) {
                $items->push($item);
            }
        }

            $container->addItems($items->all());
            $container->removeContainerByUuid($container->getUuid());

        return true;
    }
}
