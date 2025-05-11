@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            <div class="frame flex-col-13">
                <h1>{{ $enemy->getTitle() }}</h1>

                @isset($enemy->description)
                    <p>{{ $enemy->description }}</p>
                @endisset
            </div>

            <div class="frame flex-col-13">
                <h2>Содержит предметы</h2>

                @component('items.components.list', ['items' => $enemy->availableItems()])
                @endcomponent
            </div>

            <div class="frame flex-col-13">
                <h2>Встречается на локациях</h2>

                @component('locations.components.list', ['locations' => $enemy->availableLocations()])
                @endcomponent
            </div>
        </div>

        <div class="col col-4">
            <div class="frame">
                <img width="100%" src="{{ $enemy->getImageUrl() }}" alt="">
            </div>

            <div class="frame flex-col">
                <a class="link" href="{{ route('enemies.edit', $enemy) }}">Изменить запись</a>
                <form action="{{ route('enemies.destroy', $enemy) }}" method="POST"
                    onsubmit="return confirm('Удалить этот предмет?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="link">Удалить запись</button>
                </form>
            </div>

            @component('enemies.frames.stats', compact('enemy'))
            @endcomponent
        </div>
    </div>
@endsection
