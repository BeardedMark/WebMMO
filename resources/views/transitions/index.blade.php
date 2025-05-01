@extends('layouts.fill')
@section('wallpaper', $currentLocation->getImageUrl())
@section('sound', $currentLocation->getSoundUrl())

@section('content')
    <div class="relative inline-block text-left">

        <div class="row">
            <div class="col col-3 order-1">
                <div class="flex-col-8">
                    @component('locations.components.card', ['location' => $currentLocation])
                    @endcomponent

                    <div class="frame flex-col-13">
                        <div class="row g-1">
                            <div class="col">
                                <p>Предметы на локации</p>
                            </div>

                            <div class="col-auto">
                                <p>{{ $currentLocation->getSize() }} сек</p>
                            </div>

                            <div class="col-auto">
                                <form class="await" action="{{ route('transitions.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="to_location_id" value="{{ $currentLocation->id }}">
                                    <button class="icon" type="submit" data-tooltip="Переобойти локацию">
                                        @component('elements.icon', ['size' => 21, 'name' => 'refresh', 'color' => 'BAC7E3'])
                                        @endcomponent
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if (count($currentTransition->getItems()) > 0)
                            <div class="flex-col">
                                @foreach ($currentTransition->getItems() as $item)
                                    @component('items.components.move', [
                                        'item' => $item,
                                        'fromContainer' => 'transitions',
                                        'fromId' => $currentTransition->id,
                                        'toContainer' => 'characters',
                                        'toId' => $currentCharacter->id,
                                    ])
                                    @endcomponent
                                @endforeach
                            </div>
                        @endif

                        <div class="row g-1">
                            <div class="col">
                                <small class="color-second">{{ $currentTransition->getItemsCount() }}
                                    предм</small>
                            </div>

                            <div class="col-3">
                                <small class="color-second">{{ $currentTransition->getTotalItemsWeight() }} кг</small>
                            </div>

                            <div class="col-3">
                                <small class="color-second">{{ $currentTransition->getTotalItemsCount() }}</small>
                            </div>

                            <div class="col-auto">
                                @component('items.components.moves', [
                                    'fromContainer' => 'transitions',
                                    'fromId' => $currentTransition->id,
                                    'toContainer' => 'characters',
                                    'toId' => $currentCharacter->id,
                                ])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col order-2">
                <div class="flex-col-8">

                    <div class="frame">
                        @component('transitions.components.map', compact('currentCharacter'))
                        @endcomponent
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="frame">
                            </div>
                        </div>

                        @if ($currentCharacter->currentLocation())
                            <div class="col-4">
                                <div class="frame">
                                    <div class="flex-col">
                                        @foreach ($currentLocation->charactersOnLocation() as $character)
                                            @component('characters.components.link', compact('character'))
                                            @endcomponent
                                        @endforeach
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col col-3 order-3">
                <div class="flex-col-8">
                    <div class="frame flex-col-13">
                        <div class="flex-col">
                            @component('characters.components.line', ['character' => $currentCharacter])
                            @endcomponent

                            @component('transitions.components.timer')
                            @endcomponent
                        </div>
                    </div>

                    @if (auth()->user()->getHideoutAtCurrentLocation())
                        <div class="frame">
                            <p class="flex-row-8">
                                <a class="link" href="{{ route('hideouts.create') }}">{{ auth()->user()->getHideoutAtCurrentLocation()->name }}</a>
                                <span class="flex grow"></span>
                                <small>23ч</small>
                                <small class="color-brand">1 ур</small>
                            </p>
                        </div>
                    @else
                        <div class="frame flex-row-5">
                            <p class="flex grow color-second">Нет убежища в этой локации</p>
                            <a href="{{ route('hideouts.create') }}" class="icon">
                                @component('elements.icon', ['size' => 21, 'name' => 'smart-home-checked', 'color' => 'BAC7E3'])
                                @endcomponent
                            </a>
                        </div>
                    @endif

                    <div class="frame flex-col-13">
                        <div class="row g-1">
                            <div class="col">
                                <p>Инвентарь персонажа</p>
                            </div>

                            <div class="col-auto">
                                @component('items.components.swap', [
                                    'fromContainer' => 'characters',
                                    'fromId' => $currentCharacter->id,
                                    'toContainer' => 'transitions',
                                    'toId' => $currentTransition->id,
                                ])
                                @endcomponent
                            </div>
                        </div>

                        @if (count($currentCharacter->getItems()) > 0)
                            <div class="flex-col">
                                @foreach ($currentCharacter->getItems() as $item)
                                    @component('items.components.move', [
                                        'item' => $item,
                                        'fromContainer' => 'characters',
                                        'fromId' => $currentCharacter->id,
                                        'toContainer' => 'transitions',
                                        'toId' => $currentTransition->id,
                                    ])
                                    @endcomponent
                                @endforeach
                            </div>
                        @endif

                        <div class="row g-1">
                            <div class="col">
                                <small class="color-second">{{ $currentCharacter->getItemsCount() }}
                                    предм</small>
                            </div>

                            <div class="col-3">
                                <small class="color-second">{{ $currentCharacter->getTotalItemsWeight() }}
                                    кг</small>
                            </div>

                            <div class="col-3">
                                <small class="color-second">{{ $currentCharacter->getTotalItemsCount() }}</small>
                            </div>

                            <div class="col-auto">
                                @component('items.components.moves', [
                                    'fromContainer' => 'characters',
                                    'fromId' => $currentCharacter->id,
                                    'toContainer' => 'transitions',
                                    'toId' => $currentTransition->id,
                                ])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
