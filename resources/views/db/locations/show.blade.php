@extends('layouts.container')

@section('content')
    <div class="pad-13 flex-col-8">
        <h1 class="color-brand">{{ $location->getTitle() }}</h1>

        @isset($location->description)
            <p class="font-lg">{{ $location->description }}</p>
        @endisset
    </div>

    @if (count($location->connectedLocations()) > 0)
        <div id="locations">
            <div class="pad-13 flex-col-5">
                <h2>Доступные локации</h2>
                <p>Локации, в которые вы можете попасть</p>
            </div>

            <div class="frame">
                @component('db.locations.components.list', ['locations' => $location->connectedLocations()])
                @endcomponent
            </div>
        </div>
    @endif

    @if (count($location->availableEnemies()) > 0)
        <div id="enemies">
            <div class="pad-13 flex-col-5">
                <h2>Встречающиеся враги</h2>
                <p>Все обитатели, которых можно встретить на локации</p>
            </div>

            <div class="frame">
                @component('db.enemies.components.list', ['enemies' => $location->availableEnemies()])
                @endcomponent
            </div>
        </div>
    @endif

    @if (count($location->availableItems()) > 0)
        <div id="items">
            <div class="pad-13 flex-col-5">
                <h2>Выпадаемые предметы</h2>
                <p>Предметы, которые вы можете найти на локации</p>
            </div>

            <div class="frame">
                @component('db.items.components.list', ['items' => $location->availableItems()])
                @endcomponent
            </div>
        </div>
    @endif
@endsection

@section('container-sidebar')
    @component('db.locations.components.card', compact('location'))
    @endcomponent

    @component('db.locations.frames.stats', compact('location'))
    @endcomponent
@endsection
