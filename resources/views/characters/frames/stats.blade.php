{{-- style="max-height: 500px; overflow-x:auto" --}}
<div class="frame flex-col-13" >
    <p class="color-second">Характеристики</p>

    <div class="flex-col">
        @component('components.stat', ['name' => 'Сила', 'value' => $character->strength()])
        @endcomponent
        @component('components.stat', ['name' => 'Ловкость', 'value' => $character->agility()])
        @endcomponent
        @component('components.stat', ['name' => 'Интеллект', 'value' => $character->intelligence()])
        @endcomponent
    </div>

    <p class="color-second">Показатели</p>

    <div class="flex-col">
        @component('components.stat', ['name' => 'Всего здоровья', 'value' => $character->health()])
        @endcomponent
        @component('components.stat', ['name' => 'Текущее здоровье', 'value' => $character->getCurrentHealth()])
        @endcomponent
        @component('components.stat', ['name' => 'Регенерация здоровья в сек', 'value' => $character->getRegen()])
        @endcomponent
        @component('components.stat', ['name' => 'Состояние здоровья', 'value' => $character->getHealthPercent() . ' %'])
        @endcomponent

        @component('components.stat', ['name' => 'Выносливость', 'value' => $character->endurance()])
        @endcomponent
        @component('components.stat', ['name' => 'Урон', 'value' => $character->damage()])
        @endcomponent
    </div>

    <div class="flex-col">
        @component('components.stat', ['name' => 'Максимальный вес', 'value' => $character->maxWeight() . ' кг'])
        @endcomponent
        @component('components.stat', ['name' => 'Переносимый вес', 'value' => $character->getTotalItemsWeight() . ' кг'])
        @endcomponent
        @component('components.stat', ['name' => 'Недовес', 'value' => $character->maxWeight() - $character->getTotalItemsWeight() . ' кг'])
        @endcomponent
        @component('components.stat', ['name' => 'Перевес', 'value' => $character->overWeight() . ' кг'])
        @endcomponent
        @component('components.stat', ['name' => 'Ускорение действий', 'value' => $character->moveSpeed() . ' %'])
        @endcomponent
        @component('components.stat', ['name' => 'Выпадение предметов', 'value' => $character->dropChance() . ' %'])
        @endcomponent
    </div>

    <p class="color-second">Опыт и уровень</p>

    <div class="flex-col">
        @component('components.stat', ['name' => 'Текущий уровень', 'value' => $character->getLevel() . ' ур'])
        @endcomponent
        @component('components.stat', ['name' => 'Прогресс уровня', 'value' => $character->getLevelPercent() . ' %'])
        @endcomponent
        @component('components.stat', ['name' => 'Для текущего уровня', 'value' => $character->experienceToCurrentLevel() . ' оп'])
        @endcomponent
        @component('components.stat', ['name' => 'Текущий опыт', 'value' => $character->getExpiriance() . ' оп'])
        @endcomponent
        @component('components.stat', ['name' => 'Для следующего уровня', 'value' => $character->experienceToNextLevel() . ' оп'])
        @endcomponent
        @component('components.stat', ['name' => 'Нужно до следующего уровня', 'value' => $character->experienceToNextLevel() - $character->experienceToCurrentLevel() . ' оп'])
        @endcomponent
        @component('components.stat', ['name' => 'Осталось до следующего уровня', 'value' => ($character->experienceToNextLevel() - $character->experienceToCurrentLevel()) -  ($character->getExpiriance() - $character->experienceToCurrentLevel()). ' оп'])
        @endcomponent
        @component('components.stat', ['name' => 'От текущего уровня', 'value' => $character->getExpiriance() - $character->experienceToCurrentLevel() . ' оп'])
        @endcomponent
    </div>

    <p class="color-second">Статистика</p>

    <div class="flex-col">
        @component('components.stat', ['name' => 'Посещено локаций','value' => count($character->visitedLocations()),])
        @endcomponent
        @component('components.stat', ['name' => 'Совершено переходов','value' => count($character->allTransitions()->get()),])
        @endcomponent
    </div>
</div>
