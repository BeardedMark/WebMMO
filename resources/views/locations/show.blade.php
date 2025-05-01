@extends('layouts.hug')
@section('wallpaper', $currentLocation->getImageUrl())

@section('content')
    <div class="flex-col-13">
        <div class="flex-col">
            <h1>{{ $currentLocation->name }}</h1>
            <div class="flex-row-8">
                <a class="button" href="{{ route('locations.edit', $currentLocation) }}">Изменить локацию</a>
                <form action="{{ route('locations.destroy', $currentLocation) }}" method="POST"
                    onsubmit="return confirm('Удалить эту локацию?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button danger">Удалить локацию</button>
                </form>
            </div>
        </div>

        <div class="row">

            <div class="col">
                <div class="flex-col-13">

                    <div class="frame">
                        @component('items.components.list', ['items' => $currentLocation->availableItems()])
                        @endcomponent
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="flex-col-13">
                    <div class="frame">
                        @foreach ($currentLocation->connectedLocations() as $location)
                            @component('locations.components.line', compact('location'))
                            @endcomponent
                        @endforeach
                    </div>

                    <div class="frame">
                        @foreach ($currentLocation->charactersOnLocation() as $character)
                            @component('characters.components.line', compact('character'))
                            @endcomponent
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="flex-col-13">
                    @component('locations.components.card', ['location' => $currentLocation])
                    @endcomponent

                    <div class="frame flex-col">
                        <span>Состояние: {{ $currentLocation->is_open ? 'Открыто' : 'Закрыто' }}</span>
                        <span>Размер локации: {{ $currentLocation->getSize() }}</span>
                        <span>Уровень локации: {{ $currentLocation->getLevel() }}</span>
                        <span>Координаты: x:{{ $currentLocation->x }} y:{{ $currentLocation->y }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
