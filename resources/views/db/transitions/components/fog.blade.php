<mask id="fog-mask">
    <g filter="url(#blur)">
        <rect width="1024" height="1024" fill="black" />

        @foreach ($character->roadsToVisitedLocations() as $roadToVisitedLocation)
            <line x1="{{ $roadToVisitedLocation->fromLocation->x }}" y1="{{ $roadToVisitedLocation->fromLocation->y }}"
                x2="{{ $roadToVisitedLocation->toLocation->x }}" y2="{{ $roadToVisitedLocation->toLocation->y }}"
                stroke="white" stroke-width="{{ $character->getViewRange() * 2 }}" stroke-linecap="round" />
        @endforeach

        @foreach ($character->roadsToUnvisitedLocations() as $roadToUnvisitedLocation)
            <line x1="{{ $roadToUnvisitedLocation->fromLocation->x }}"
                y1="{{ $roadToUnvisitedLocation->fromLocation->y }}" x2="{{ $roadToUnvisitedLocation->toLocation->x }}"
                y2="{{ $roadToUnvisitedLocation->toLocation->y }}" stroke="white"
                stroke-width="{{ $character->getViewRange() / 2 }}" stroke-linecap="round" />
        @endforeach

        @if ($character->currentLocation())
            <circle cx="{{ $character->currentLocation()->x }}" cy="{{ $character->currentLocation()->y }}"
                r="{{ $character->getViewRange() }}" fill="white" />
        @endif
    </g>
</mask>

<filter id="blur">
    <feGaussianBlur stdDeviation="15" />
</filter>
