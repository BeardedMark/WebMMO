@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            <div class="frame flex-col-13">
                <h1>{{ $location->getTitle() }}</h1>
                @isset($location->description)
                    <p>{{ $location->description }}</p>
                @endisset
            </div>

            <div class="frame flex-col-13">
                <h2>Встречающиеся враги</h2>

                @component('enemies.components.list', ['enemies' => $location->availableEnemies()])
                @endcomponent
            </div>

            <div class="frame flex-col-13">
                <h2>Выпадающие предметы</h2>

                @component('items.components.list', ['items' => $location->availableItems()])
                @endcomponent
            </div>

            <div class="frame flex-col-13">
                <h2>Доступные локации</h2>

                <div class="">
                    @foreach ($location->connectedLocations() as $connectedLocation)
                        @component('locations.components.line', ['location' => $connectedLocation])
                        @endcomponent
                    @endforeach
                </div>
            </div>

            <div class="frame flex-col-13">
                <h2>Персонажи на локации</h2>
                @foreach ($location->charactersOnLocation() as $character)
                    @component('characters.components.line', compact('character'))
                    @endcomponent
                @endforeach
            </div>
        </div>

        <div class="col col-4">
            @component('locations.components.card', compact('location'))
            @endcomponent

            <div class="frame flex-col">
                <a class="link" href="{{ route('locations.edit', $location) }}">Изменить локацию</a>
                <form action="{{ route('locations.destroy', $location) }}" method="POST"
                    onsubmit="return confirm('Удалить эту локацию?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="link">Удалить локацию</button>
                </form>
            </div>

            @component('locations.frames.stats', compact('location'))
            @endcomponent
        </div>
    </div>
@endsection
