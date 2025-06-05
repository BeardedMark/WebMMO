@extends('db.locations.layouts.location')

@section('top-content')
    <div class="frame flex-row-13 ai-center font-sm">
        <form class="flex await" action="{{ route('transitions.update', $transition) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="location_id" value="{{ $location->id }}">
            <button class="icon" type="submit" data-tooltip="Переобойти локацию">
                @component('components.icon', ['size' => 28, 'name' => 'refresh', 'color' => 'FFFFFF'])
                @endcomponent
            </button>
        </form>

        <a class="link lock-gray-dark-blur">
            @component('components.icon', ['size' => 28, 'name' => 'map-pin', 'color' => 'FFFFFF'])
            @endcomponent
        </a>

        <span class="flex grow"></span>
        <span class="color-second">{{ count($transition->getItems()) }} предм.</span>
        <span class="color-brand">{{ count($transition->getEnemies()) }} враг.</span>
    </div>
@endsection

@section('left-content')
    <div class="frame flex-col-13">
        <p class="font-sm">Предметы на местности</p>

        @if (count($transition->getItems()) > 0)
            @component('db.items.components.inventory', [
                'fromContainer' => $transition,
                'toContainer' => $character,
            ])
            @endcomponent
        @else
            <p class="color-second">Ничего не найдено</p>
        @endif
    </div>
@endsection

@section('right-content')
    <div class="frame flex-col-13">
        <p class="font-sm">Враги на локаии</p>
        @if (count($transition->getEnemies()) > 0)
            <div class="grid">
                @foreach ($transition->getEnemies() as $enemy)
                    @component('db.enemies.components.battle', compact('enemy'))
                    @endcomponent
                @endforeach
            </div>
        @else
            <p class="color-second">Никого не встречено</p>
        @endif
    </div>
@endsection
