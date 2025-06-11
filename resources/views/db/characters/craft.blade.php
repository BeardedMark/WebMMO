@extends('db.characters.inventory')

@section('left-content')
    <div class="frame flex-col-13">
        @component('components.header-sm', [
            'header' => 'Создание предметов',
            'note' => 'x' . count($character->getAvailableCrafts($character->getLevel())),
        ])
        @endcomponent

        <div class="grid">
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
