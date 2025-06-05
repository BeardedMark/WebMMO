@extends('db.locations.layouts.location')

@section('right-content')
    <div class="frame flex-col-13">
        <p>Предметы в инвентаре</p>
        @component('db.items.components.inventory', [
            'fromContainer' => $character,
            'toContainer' => $character->transition,
        ])
        @endcomponent
    </div>

    <div class="frame flex-col-13">
        <p>Создание предметов</p>
        <div class="color-second">
            @if (count($character->getAvailableCrafts($character->getLevel())) > 0)
                @foreach ($character->getAvailableCrafts($character->getLevel()) as $availableCraftItem)
                    @component('db.items.components.assemble', [
                        'item' => $availableCraftItem,
                        'fromContainer' => $character->getTable(),
                        'fromId' => $character->id,
                    ])
                    @endcomponent
                @endforeach
            @else
                <p class="color-second font-sm">Нет доступных рецептов</p>
            @endif
        </div>
    </div>
@endsection


@section('left-content')
    <div class="frame flex-col-13">
        <p>Эффекты от экипировки</p>
        <div class="color-second">
            @if (count($character->getEquipmentModifiers()) > 0)
                @foreach ($character->getEquipmentModifiers() as $mod)
                    @component('components.stat', ['name' => $mod->getName(), 'value' => $mod->getValueTitle()])
                    @endcomponent
                @endforeach
            @else
                <p class="color-second font-sm">Нет экипированных предметов</p>
            @endif
        </div>
    </div>

    <div class="frame flex-col-13">
        <p>Эффекты от навыков</p>
        <div class="color-second">
            <p class="color-second font-sm">Нет вкаченных навыков</p>
        </div>
    </div>
@endsection
