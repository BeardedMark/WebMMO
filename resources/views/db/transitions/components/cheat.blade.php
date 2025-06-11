@php
    use App\Models\Road;
    use App\Domains\Locations\Models\Location;
    $allRoads = Road::all();
    $allLocations = Location::all();
@endphp

@foreach ($allRoads as $road)
    @if ($road->fromLocation && $road->fromLocation)
        <line stroke="red" x1="{{ $road->fromLocation->x }}" y1="{{ $road->fromLocation->y }}"
            x2="{{ $road->toLocation->x }}" y2="{{ $road->toLocation->y }}" stroke-width="1" />
    @endif
@endforeach

@foreach ($allLocations as $location)
    <circle r="3" fill="red" cx="{{ $location->x }}" cy="{{ $location->y }}" />
    <text x="{{ $location->x }}" y="{{ $location->y }}"
        style="fill: white; font: 12px serif;">{{ $location->name }}#{{ $location->id }}</text>
@endforeach
