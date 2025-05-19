<div class="frame flex-col-13" >
    <div>
        @component('components.stat', ['name' => 'Класс предмета','value' => $item->class])
        @endcomponent
        @component('components.stat', ['name' => 'Вес одной еденицы','value' => $item->getWeightTitle()])
        @endcomponent
        @component('components.stat', ['name' => 'Шанс выпадения','value' => $item->getDropChance() . ' %'])
        @endcomponent
    </div>

    <div>
        @component('components.stat', ['name' => 'Максимальная стопка','value' => $item->getMaxStack()])
        @endcomponent
        @component('components.stat', ['name' => 'Максимум модификаций','value' => $item->getMaxModifiers()])
        @endcomponent
        @component('components.stat', ['name' => 'Минимальный уровень', 'value' => $item->getMinLevel()])
        @endcomponent
        @component('components.stat', ['name' => 'Максимальный уровень', 'value' => $item->getMaxLevel()])
        @endcomponent
        @component('components.stat', ['name' => 'Максимальный уровень', 'value' => $item->getMaxLevel()])
        @endcomponent
    </div>

    <div>
        @component('components.stat', ['name' => 'Содержит характеристик', 'value' => count($item->getPropertiesArray())])
        @endcomponent
        @component('components.stat', ['name' => 'Возможных модификаций', 'value' => count($item->getModifiersArray())])
        @endcomponent
        @component('components.stat', ['name' => 'Содержит предметов', 'value' => count($item->getCraftArray())])
        @endcomponent
    </div>

    <div>
        @component('components.stat', ['name' => 'Доступных локаций', 'value' => count($item->availableLocations())])
        @endcomponent
        @component('components.stat', ['name' => 'Содержится в предметах', 'value' => count($item->usedInCrafts())])
        @endcomponent
        @component('components.stat', ['name' => 'Выпадает из врагов', 'value' => count($item->droppedByEnemies())])
        @endcomponent
    </div>

    <div>
        @component('components.datetime', ['entity' => $item])
        @endcomponent
    </div>
</div>
