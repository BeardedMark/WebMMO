{{-- style="max-height: 500px; overflow-x:auto" --}}
<div class="frame flex-col-13" >
    <div>
        @component('components.stat', ['name' => 'Уровень опастности', 'value' => $enemy->danger()])
        @endcomponent
        @component('components.stat', ['name' => 'Шанс появления', 'value' => $enemy->getSpawnChance()])
        @endcomponent
        @component('components.stat', ['name' => 'Минимальный уровень', 'value' => $enemy->getMinLevel()])
        @endcomponent
        @component('components.stat', ['name' => 'Максимальный уровень', 'value' => $enemy->getMaxLevel()])
        @endcomponent
        @component('components.stat', ['name' => 'Выпадаемых предметов', 'value' => count($enemy->availableItems())])
        @endcomponent
        @component('components.stat', ['name' => 'Обитаемых локаций', 'value' => count($enemy->availableLocations())])
        @endcomponent
    </div>

    <div>
        @component('components.datetime', ['entity' => $enemy])
        @endcomponent
    </div>
</div>
