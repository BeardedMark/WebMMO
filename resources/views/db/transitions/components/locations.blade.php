@foreach ($character->visitedLocations() as $visitedLocation)
    <circle r="8" class="svg-location" cx="{{ $visitedLocation->x }}" cy="{{ $visitedLocation->y }}"
        data-tooltip="{{ $visitedLocation->getTitle() }} (Посещено)" />

    @if ($visitedLocation->charactersCount() > 0)
        <circle r="3" class="svg-location-active" cx="{{ $visitedLocation->x }}" cy="{{ $visitedLocation->y }}" />
    @else
        <circle r="3" class="svg-location-visited" cx="{{ $visitedLocation->x }}" cy="{{ $visitedLocation->y }}" />
    @endif
@endforeach

@foreach ($character->unvisitedLocations() as $unvisitedLocation)
    <circle r="8" class="svg-location-unvisited" cx="{{ $unvisitedLocation->x }}" cy="{{ $unvisitedLocation->y }}"
        data-tooltip="??? (Непосещено)" />
@endforeach

@foreach ($character->availableLocations() as $availableLocation)
    <circle r="8" class="svg-location-available await hidden" fill="transparent" class="svg-icon available await"
        cx="{{ $availableLocation->x }}" cy="{{ $availableLocation->y }}" data-id="{{ $availableLocation->id }}"
        data-name="{{ $availableLocation->name }}" onclick="redirectToLocation({{ $availableLocation->id }})"
        data-tooltip="{{ $availableLocation->getTitle() }} (Перейти)" />
@endforeach

@if ($character->currentLocation())
    <circle r="8" class="svg-location-current font-light-brand" cx="{{ $character->currentLocation()->x }}"
        cy="{{ $character->currentLocation()->y }}"
        data-tooltip="{{ $character->currentLocation()->getTitle() }} (Вы тут)" />

    @if ($character->currentBattle())
        <image class="lock" href="{{ asset('storage/images/icons/battle.png') }}"
            x="{{ $character->currentLocation()->x - 16 }}" y="{{ $character->currentLocation()->y - 16 }}"
            width="32" height="32" />
    @endif
@endif
