<div class="frame flex-col-13" >
    <div>
        @component('components.stat', ['name' => 'Вес одной еденицы','value' => $item->getWeight() . ' кг'])
        @endcomponent
        @component('components.stat', ['name' => 'Шанс выпадения','value' => $item->getDropChance()])
        @endcomponent
        @component('components.stat', ['name' => 'Минимальный уровень', 'value' => $item->getMinLevel()])
        @endcomponent
        @component('components.stat', ['name' => 'Максимальный уровень', 'value' => $item->getMaxLevel()])
        @endcomponent
        @component('components.stat', ['name' => 'Содержит предметов', 'value' => count($item->getCraftItems())])
        @endcomponent
        @component('components.stat', ['name' => 'Содержится в предметах', 'value' => count($item->usedInCrafts())])
        @endcomponent
        @component('components.stat', ['name' => 'Локаций для находок', 'value' => count($item->availableLocations())])
        @endcomponent
        @component('components.stat', ['name' => 'Выпадает из врагов', 'value' => count($item->droppedByEnemies())])
        @endcomponent
    </div>

    <div>
        @component('components.datetime', ['entity' => $item])
        @endcomponent
    </div>
</div>
