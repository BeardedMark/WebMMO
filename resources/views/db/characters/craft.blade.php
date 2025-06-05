@extends('db.characters.inventory')

@section('right-content')
    <div class="frame flex-col-13">
        <p>Предметы в инвентаре</p>
        @component('db.items.components.inventory', [
            'fromContainer' => $character,
            'toContainer' => $character->transition,
        ])
        @endcomponent
    </div>
@endsection

@section('left-content')
    <div class="frame">
        @if (count($character->getAvailableCrafts($character->getLevel())) > 0)
            <div class="flex-col">
                @foreach ($character->getAvailableCrafts($character->getLevel()) as $availableCraftItem)
                    @component('db.items.components.assemble', [
                        'item' => $availableCraftItem,
                        'fromContainer' => $character->getTable(),
                        'fromId' => $character->id,
                    ])
                    @endcomponent
                @endforeach
            </div>
        @else
            <p class="color-second">Нет доступных крафтов или предметов</p>
        @endif
    </div>
@endsection
