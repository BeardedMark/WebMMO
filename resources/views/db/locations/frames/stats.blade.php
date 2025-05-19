<div class="frame flex-col-13" >
    <div>
        @component('components.stat', ['name' => 'Уровень','value' => $location->getLevel(),])
        @endcomponent
        @component('components.stat', ['name' => 'Размер','value' => $location->getSize(),])
        @endcomponent
        @component('components.stat', ['name' => 'Координаты по X','value' => $location->getCordX(),])
        @endcomponent
        @component('components.stat', ['name' => 'Координаты по Y','value' => $location->getCordY(),])
        @endcomponent
        @component('components.stat', ['name' => 'Состояние','value' => $location->getStatusTitle(),])
        @endcomponent
    </div>

    <div>
        @component('components.stat', ['name' => 'Выпадаемых предметов', 'value' => count($location->availableItems()), 'link' => '#items'])
        @endcomponent
        @component('components.stat', ['name' => 'Обитаемых врагов', 'value' => count($location->availableEnemies()), 'link' => '#enemies'])
        @endcomponent
        @component('components.stat', ['name' => 'Доступных локаций', 'value' => count($location->connectedLocations()), 'link' => '#locations'])
        @endcomponent
        @component('components.stat', ['name' => 'Персонажей на локации', 'value' => count($location->charactersOnLocation()), 'link' => '#characters'])
        @endcomponent
    </div>

    <div>
        @component('components.datetime', ['entity' => $location])
        @endcomponent
    </div>
</div>
