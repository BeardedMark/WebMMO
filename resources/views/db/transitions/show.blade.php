@extends('db.locations.layouts.location')

@section('top-content')
    <div class="frame flex-row-8 ai-center">
        <p class="flex-row-8 flex-grow ai-center">
            <span class="color-brand">Текущая местность на локации</span>
        </p>

        <a class="link lock-gray-dark-blur" data-tooltip="Запомнить местность">
            @component('components.icon', ['size' => 28, 'name' => 'map-pin', 'color' => 'FFFFFF'])
            @endcomponent
        </a>

        <form class="flex await" action="{{ route('transitions.update', $transition) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="location_id" value="{{ $location->id }}">
            <button class="icon" type="submit" data-tooltip="Переобойти локацию, обновив местность">
                @component('components.icon', ['size' => 28, 'name' => 'refresh', 'color' => 'FFFFFF'])
                @endcomponent
            </button>
        </form>
    </div>
@endsection

@section('left-content')
    <div class="frame flex-col-13">
        @component('components.header-sm', [
            'header' => 'Предметы на местности',
            'note' => 'x' . count($character->transition->getItems()),
        ])
        @endcomponent

        @if (count($transition->getItems()) > 0)
            @component('db.items.components.inventory', [
                'fromContainer' => $character->transition,
                'toContainer' => $character,
            ])
            @endcomponent
        @else
            <p class="font-sm color-second">Ничего не найдено</p>
        @endif
    </div>
@endsection

@section('right-content')
    <div class="frame flex-col-13">
        @component('components.header-sm', [
            'header' => 'Встречи на местности',
            'note' => 'x' . count($transition->getEnemies()),
        ])
        @endcomponent

        @if (count($transition->getEnemies()) > 0)
            <div class="grid">
                @foreach ($transition->getEnemies() as $enemy)
                    @component('db.enemies.components.battle', compact('enemy'))
                    @endcomponent
                @endforeach
            </div>
        @else
            <p class="font-sm color-second">Никого не встречено</p>
        @endif
    </div>
@endsection
