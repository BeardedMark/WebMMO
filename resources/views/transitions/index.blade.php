@extends('characters.layouts.sidebar')
@section('wallpaper', $currentLocation->getImageUrl())
@section('sound', $currentLocation->getSoundUrl())

@section('character-content')
    <div class="row">
        <div class="col col-4 order-1">
            <div class="flex-col">

                <div class="frame flex-col-8">
                    @component('locations.components.line', ['location' => $currentLocation])
                    @endcomponent

                    <div class="flex-row-8">
                        <p class="flex grow color-brand">
                        </p>

                        @if (auth()->user()->getHideoutAtCurrentLocation())
                            <form class="await" action="{{ route('transitions.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="location_id" value="{{ $currentLocation->id }}">
                                <input type="hidden" name="hideout_id" value="{{ auth()->user()->getHideoutAtCurrentLocation()->id }}">
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

                        <form class="await" action="{{ route('transitions.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="location_id" value="{{ $currentLocation->id }}">
                            <button class="icon" type="submit" data-tooltip="Переобойти локацию">
                                @component('components.icon', ['size' => 21, 'name' => 'refresh', 'color' => 'BAC7E3'])
                                @endcomponent
                            </button>
                        </form>
                    </div>
                </div>

                @if (auth()->user()->getHideoutAtCurrentLocation())
                    <div class="frame">
                        @component('hideouts.components.line', ['hideout' => auth()->user()->getHideoutAtCurrentLocation()])
                        @endcomponent
                    </div>
                @endif

                @if (count($currentTransition->enemies()) > 0)
                    <div class="frame">
                        <div class="flex-col">
                            @foreach ($currentTransition->enemies() as $enemy)
                                @component('enemies.components.battle', compact('enemy'))
                                @endcomponent
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (count($currentTransition->getItems()) > 0)
                    @component('items.components.inventory', [
                        'fromContainer' => $currentTransition,
                        'toContainer' => $currentCharacter,
                    ])
                    @endcomponent
                @endif
            </div>
        </div>

        <div class="col order-2">
            <div class="flex-col">
                <div class="frame">
                    @component('transitions.components.map', compact('currentCharacter'))
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
