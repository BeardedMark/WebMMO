@extends('db.characters.layouts.sidebar')
@section('wallpaper', $location->getImageUrl())
@section('sound', $location->getSoundUrl())

@section('character-content')
    <div class="row">
        <div class="col">
            <div class="flex-col">
                @component('db.transitions.components.map', compact('character'))
                @endcomponent
            </div>
        </div>

        <div class="col col-4">
            <div class="flex-col-5">

                <div class="frame flex-col-13">
                    @component('db.locations.components.line', compact('location'))
                    @endcomponent

                    {{-- <div class="flex-row-8">
                        <p class="flex grow color-brand">
                        </p>

                        @if (auth()->user()->getHideoutAtCurrentLocation())
                            <form class="await" action="{{ route('transitions.store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="location_id" value="{{ $location->id }}">
                                <input type="hidden" name="hideout_id"
                                    value="{{ auth()->user()->getHideoutAtCurrentLocation()->id }}">
                                <button class="icon" type="submit" data-tooltip="Переобойти локацию">
                                    @component('components.icon', ['size' => 21, 'name' => 'refresh', 'color' => 'BAC7E3'])
                                    @endcomponent
                                </button>
                            </form>
                        @else
                            <a href="{{ route('hideouts.create') }}" class="icon await">
                                @component('components.icon', ['size' => 21, 'name' => 'smart-home-checked', 'color' => 'BAC7E3'])
                                @endcomponent
                            </a>
                        @endif

                        <form class="await" action="{{ route('transitions.update', $transition) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="location_id" value="{{ $location->id }}">
                            <button class="icon" type="submit" data-tooltip="Переобойти локацию">
                                @component('components.icon', ['size' => 21, 'name' => 'refresh', 'color' => 'BAC7E3'])
                                @endcomponent
                            </button>
                        </form>
                    </div> --}}

                    <div class="flex-row">
                        <form class="await w-100" action="{{ route('transitions.update', $transition) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="location_id" value="{{ $location->id }}">
                            <button class="button w-100" type="submit"
                                data-tooltip="Переобойти локацию">Переобойти</button>
                        </form>

                        <a class="button w-100 lock-gray-dark-blur" href="{{ route('transitions.index') }}">Поединки</a>
                        <a class="button w-100 lock-gray-dark-blur" href="{{ route('transitions.index') }}">Убежища</a>
                    </div>
                </div>

                @if (auth()->user()->getHideoutAtCurrentLocation())
                    <div>
                        @component('hideouts.components.line', ['hideout' => auth()->user()->getHideoutAtCurrentLocation()])
                        @endcomponent
                    </div>
                @endif

                @if (count($transition->enemies()) > 0)
                    <div class="frame flex-row wrap">
                        @foreach ($transition->enemies() as $enemy)
                            @component('db.enemies.components.battle', compact('enemy'))
                            @endcomponent
                        @endforeach
                    </div>
                @endif

                @if (count($transition->getItems()) > 0)
                    @component('db.items.components.inventory', [
                        'fromContainer' => $transition,
                        'toContainer' => $character,
                    ])
                    @endcomponent
                @endif
            </div>
        </div>
    </div>
@endsection
