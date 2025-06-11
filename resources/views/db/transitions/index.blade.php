@extends('db.locations.layouts.location')

@section('top-content')
    <div class="frame flex-row-8 ai-center">
        <p class="flex-grow">
            <span class="color-brand">Мировая карта локаций</span>
        </p>

        <div class="color-second font-sm" id="cursor-coordinates" data-default-x="{{ $character->currentLocation()->x }}"
            data-default-y="{{ $character->currentLocation()->y }}" class="font-sm color-second">
            X: {{ $character->currentLocation()->x }}, Y: {{ $character->currentLocation()->y }}
        </div>

        <button class="icon" onclick="showCurrentLocation()" data-tooltip="Текущая локация">
            @component('components.icon', ['name' => 'marker', 'size' => 28, 'color' => 'FFFFFF'])
            @endcomponent
        </button>

        <button class="icon" onclick="fitMapToView()" data-tooltip="Все локации">
            @component('components.icon', ['name' => 'address', 'size' => 28, 'color' => 'FFFFFF'])
            @endcomponent
        </button>

        <button class="icon" onclick="openFullscreen()" data-tooltip="На весь экран">
            @component('components.icon', ['name' => 'full-screen--v1', 'size' => 28, 'color' => 'FFFFFF'])
            @endcomponent
        </button>
    </div>
@endsection

@section('mid-content')
    <div class="frame flex-col-13">
        @component('db.transitions.components.map', compact('character'))
        @endcomponent
    </div>
@endsection
