@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <div class="flex-col">
            <h1>{{ $currentLocation->name }}</h1>
            <div class="flex-row-8">
                <a class="button" href="{{ route('locations.edit', $currentLocation) }}">Изменить локацию</a>
                <form action="{{ route('locations.destroy', $currentLocation) }}" method="POST" onsubmit="return confirm('Удалить эту локацию?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button danger">Удалить локацию</button>
                </form>
            </div>
        </div>

    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="frame flex-col-13">
                    <strong>Подробности о локации</strong>

                    <div class="flex-col">
                        <span>Описание: {{ $currentLocation->description }}</span>
                        <span>Состояние: {{ $currentLocation->is_open ? 'Открыто' : 'Закрыто' }}</span>
                        <span>Размер локации: {{ $currentLocation->getSize() }}</span>
                        <span>Уровень локации: {{ $currentLocation->level }}</span>
                        <span>Координаты: {{ $currentLocation->x }}:{{ $currentLocation->y }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="flex-col-13">

                <div class="frame flex-col-13">
                    <strong>Доступные локации</strong>

                    <div class="flex-col">
                        @foreach ($currentLocation->connectedLocations() as $location)
                            <a class="link" href="{{ route('locations.show', $location) }}">{{ $location->getTitle() }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="frame flex-col-13">
                    <strong>Персонажи на локации</strong>
                    <div class="flex-col">
                        @foreach ($currentLocation->charactersOnLocation() as $character)
                            <a class="link"
                                href="{{ route('characters.show', $character) }}">{{ $character->getTitle() }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="flex-col-13">
                <div class="frame">
                    <p>История локации</p>
                    <ul>
                        @foreach ($currentLocation->allTransitions() as $transition)
                            <li>
                                <small>[{{ $transition->created_at }}]</small>
                                <a class="link"
                                    href="{{ route('characters.show', $transition->character) }}">{{ $transition->character->getTitle() }}</a>
                                @if ($transition->toLocation->id == $currentLocation->id)
                                    <span> вошел на локацию</span>
                                @else
                                    <span> ушел с локации</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
