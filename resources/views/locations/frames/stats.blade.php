<div class="frame flex-col-13" >
    <div>
        @component('components.stat', ['name' => 'Уровень','value' => $location->getLevel(),])
        @endcomponent
        @component('components.stat', ['name' => 'Состояние','value' => $location->is_open ? 'Открыто' : 'Закрыто',])
        @endcomponent
        @component('components.stat', ['name' => 'Размер','value' => $location->getSize(),])
        @endcomponent
        @component('components.stat', ['name' => 'Координаты по X','value' => $location->x,])
        @endcomponent
        @component('components.stat', ['name' => 'Координаты по Y','value' => $location->y,])
        @endcomponent
        @component('components.stat', ['name' => 'Выпадаемых предметов', 'value' => count($location->availableItems())])
        @endcomponent
        @component('components.stat', ['name' => 'Обитаемых врагов', 'value' => count($location->availableEnemies())])
        @endcomponent
        @component('components.stat', ['name' => 'Доступных локаций', 'value' => count($location->connectedLocations())])
        @endcomponent
        @component('components.stat', ['name' => 'Персонажей на локации', 'value' => count($location->charactersOnLocation())])
        @endcomponent
    </div>

    <div>
        @component('components.datetime', ['entity' => $location])
        @endcomponent
    </div>
</div>
