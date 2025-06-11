@foreach ($character->roadsToUnvisitedLocations() as $roadToUnvisitedLocation)
            @if ($roadToUnvisitedLocation->fromLocation && $roadToUnvisitedLocation->fromLocation)
                <line class="svg-road unvisited" stroke-width="3" x1="{{ $roadToUnvisitedLocation->fromLocation->x }}"
                    y1="{{ $roadToUnvisitedLocation->fromLocation->y }}"
                    x2="{{ $roadToUnvisitedLocation->toLocation->x }}"
                    y2="{{ $roadToUnvisitedLocation->toLocation->y }}"
                    data-tooltip="{{ $roadToUnvisitedLocation->getDistance() }}м / {{$roadToUnvisitedLocation->getTimeToDistanceFormatted($character->getMoveSpeed())}} (Неизведанно)" />
            @endif
        @endforeach

        @foreach ($character->roadsToVisitedLocations() as $roadToVisitedLocation)
            @if ($roadToVisitedLocation->fromLocation && $roadToVisitedLocation->toLocation)
                @php
                    $roadWidth = 1 + max(count($roadToVisitedLocation->fromLocation->availableRoads()), count($roadToVisitedLocation->toLocation->availableRoads()));
                @endphp

                @if ($roadToVisitedLocation->is_one_way)
                    @php
                        $from = $roadToVisitedLocation->fromLocation;
                        $to = $roadToVisitedLocation->toLocation;
                        $gradId = 'grad-' . $roadToVisitedLocation->id;
                    @endphp

                    <defs>
                        <linearGradient id="{{ $gradId }}" gradientUnits="userSpaceOnUse"
                            x1="{{ $from->x }}" y1="{{ $from->y }}" x2="{{ $to->x }}"
                            y2="{{ $to->y }}">
                            <stop offset="0%" stop-color="var(--color-other)" stop-opacity="1" />
                            <stop offset="100%" stop-color="var(--color-other)" stop-opacity="0" />
                        </linearGradient>
                    </defs>

                    <line class="svg-road" stroke="url(#{{ $gradId }})" stroke-width="{{ $roadWidth }}" x1="{{ $from->x }}"
                        y1="{{ $from->y }}" x2="{{ $to->x }}" y2="{{ $to->y }}"
                        data-tooltip="{{ $roadToVisitedLocation->getDistance() }}м / {{$roadToVisitedLocation->getTimeToDistanceFormatted($character->getMoveSpeed())}} (Однонаправленная)" />
                @else
                    <line class="svg-road visited" stroke-width="{{ $roadWidth }}" x1="{{ $roadToVisitedLocation->fromLocation->x }}"
                        y1="{{ $roadToVisitedLocation->fromLocation->y }}"
                        x2="{{ $roadToVisitedLocation->toLocation->x }}"
                        y2="{{ $roadToVisitedLocation->toLocation->y }}"
                        data-tooltip="{{ $roadToVisitedLocation->getDistance() }}м / {{$roadToVisitedLocation->getTimeToDistanceFormatted($character->getMoveSpeed())}}"/>
                @endif
            @endif
        @endforeach

        @if ($character->currentLocation())
            @foreach ($character->availableRoads() as $availableRoad)
                @if ($availableRoad->fromLocation && $availableRoad->fromLocation)
                    <line class="svg-road available await hidden lock" stroke-width="2"
                        x1="{{ $availableRoad->fromLocation->x }}" y1="{{ $availableRoad->fromLocation->y }}"
                        x2="{{ $availableRoad->toLocation->x }}" y2="{{ $availableRoad->toLocation->y }}"
                        />
                @endif
            @endforeach
        @endif
