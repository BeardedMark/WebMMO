@extends('layouts.hug')
@section('wallpaper', $character->currentLocation()->getImageUrl())

@section('content')
    <h1>
        {{ $character->getTitle() }}</h1>

    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="frame">
                    <p>О персонаже</p>

                    <div class="flex-col">
                        <span>Статус: {{ $character->getStatus() }}</span>
                        <span>Уровень: {{ $character->getLevel() }} ({{ $character->getExpiriance() }} опыта)</span>
                        <span>Пользователь: <a class="link" href="{{ route('users.show', $character->user) }}">{{ $character->user->getTitle() }}</a>
                        </span>

                        <span>Локация:
                            @component('locations.elements.link', ['location' => $character->currentLocation()])
                            @endcomponent
                        </span>
                        <span>Время задержки: {{ $character->timeToNextAction() }}</span>
                        <span>Время на локации: {{ $character->timeOnCurrentLocation() }}</span>
                    </div>
                </div>

                <div class="frame">
                    <p>Предметов: {{ count($character->items) }}</p>

                    <div class="flex-col">
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="flex-col-13">
                <div class="frame">
                    <p>Открытые локации</p>

                    <div class="flex-col">
                        @foreach ($character->visitedLocations() as $location)
                            @component('locations.elements.link', compact('location'))
                            @endcomponent
                        @endforeach
                    </div>
                </div>

                <div class="frame">
                    <p>История переходов</p>

                    <div class="flex-col">
                        @foreach ($character->latestTransitions() as $transition)
                            <span>
                                [{{ $transition->created_at }}]
                                @component('locations.elements.link', ['location' => $transition->toLocation])
                                @endcomponent
                                #{{ $transition->id }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
