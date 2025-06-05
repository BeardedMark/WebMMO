<svg class="svg-map" id="map-svg" width="100%" height="500" xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink">
    <g id="map" transform="translate(0,0) scale(1)">

        <defs>
            <mask id="fog-mask">
                <g filter="url(#blur)">
                    <rect width="1024" height="1024" fill="black" />

                    @foreach ($character->roadsToVisitedLocations() as $roadToVisitedLocation)
                        <line x1="{{ $roadToVisitedLocation->fromLocation->x }}"
                            y1="{{ $roadToVisitedLocation->fromLocation->y }}"
                            x2="{{ $roadToVisitedLocation->toLocation->x }}"
                            y2="{{ $roadToVisitedLocation->toLocation->y }}" stroke="white"
                            stroke-width="{{ $character->getViewRange() * 2 }}" stroke-linecap="round" />
                    @endforeach

                    @foreach ($character->roadsToUnvisitedLocations() as $roadToUnvisitedLocation)
                        <line x1="{{ $roadToUnvisitedLocation->fromLocation->x }}"
                            y1="{{ $roadToUnvisitedLocation->fromLocation->y }}"
                            x2="{{ $roadToUnvisitedLocation->toLocation->x }}"
                            y2="{{ $roadToUnvisitedLocation->toLocation->y }}" stroke="white"
                            stroke-width="{{ $character->getViewRange() / 2 }}" stroke-linecap="round" />
                    @endforeach

                    @if ($character->currentLocation())
                        <circle cx="{{ $character->currentLocation()->x }}"
                            cy="{{ $character->currentLocation()->y }}" r="{{ $character->getViewRange() }}"
                            fill="white" />
                    @endif
                </g>
            </mask>

            <filter id="blur">
                <feGaussianBlur stdDeviation="15" />
            </filter>

            <marker id="arrowhead" markerWidth="6" markerHeight="6" refX="5" refY="3" orient="auto"
                markerUnits="strokeWidth">
                <path d="M0,0 L0,6 L6,3 z" fill="red" />
            </marker>

            {{-- <linearGradient id="fade-line-gradient" x1="100%" y1="0%" x2="0%" y2="0%">
                    <stop offset="0%" stop-color="var(--color-other)" stop-opacity="1" />
                    <stop offset="100%" stop-color="var(--color-other)" stop-opacity="0" />
                </linearGradient> --}}
        </defs>

        <image class="svg-icon lock" href="{{ asset('storage/images/islands/201173.png') }}" x="0" y="0" width="1024"
            mask="url(#fog-mask)" height="1024" />

        {{-- Roads --}}

        @foreach ($character->roadsToUnvisitedLocations() as $roadToUnvisitedLocation)
            @if ($roadToUnvisitedLocation->fromLocation && $roadToUnvisitedLocation->fromLocation)
                <line class="svg-road unvisited" stroke-width="3"
                    x1="{{ $roadToUnvisitedLocation->fromLocation->x }}"
                    y1="{{ $roadToUnvisitedLocation->fromLocation->y }}"
                    x2="{{ $roadToUnvisitedLocation->toLocation->x }}"
                    y2="{{ $roadToUnvisitedLocation->toLocation->y }}" />
            @endif
        @endforeach

        @foreach ($character->roadsToVisitedLocations() as $roadToVisitedLocation)
            @if ($roadToVisitedLocation->fromLocation && $roadToVisitedLocation->fromLocation)
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

                    <line stroke="url(#{{ $gradId }})" stroke-width="3" x1="{{ $from->x }}"
                        y1="{{ $from->y }}" x2="{{ $to->x }}" y2="{{ $to->y }}" />
                @else
                    <line class="svg-road visited" stroke-width="3"
                        x1="{{ $roadToVisitedLocation->fromLocation->x }}"
                        y1="{{ $roadToVisitedLocation->fromLocation->y }}"
                        x2="{{ $roadToVisitedLocation->toLocation->x }}"
                        y2="{{ $roadToVisitedLocation->toLocation->y }}" />
                @endif
            @endif
        @endforeach

        @if ($character->currentLocation())
            @foreach ($character->availableRoads() as $availableRoad)
                @if ($availableRoad->fromLocation && $availableRoad->fromLocation)
                    <line class="svg-road available await hidden" stroke-width="2"
                        x1="{{ $availableRoad->fromLocation->x }}" y1="{{ $availableRoad->fromLocation->y }}"
                        x2="{{ $availableRoad->toLocation->x }}" y2="{{ $availableRoad->toLocation->y }}" />
                @endif
            @endforeach
        @endif

        {{-- Locations --}}

        @foreach ($character->visitedLocations() as $visitedLocation)
            <image class="svg-icon" href="{{ asset('storage/images/icons/novisited.png') }}"
                x="{{ $visitedLocation->x - 15 }}" y="{{ $visitedLocation->y - 15 }}" width="30" height="30" />
        @endforeach

        @foreach ($character->availableLocations() as $availableLocation)
            <image class="await hidden" href="{{ asset('storage/images/icons/unvisited.png') }}"
                x="{{ $availableLocation->x - 15 }}" y="{{ $availableLocation->y - 15 }}" width="30"
                height="30" />

            <circle r="13" fill="transparent" class="svg-icon available await" cx="{{ $availableLocation->x }}"
                cy="{{ $availableLocation->y }}" data-id="{{ $availableLocation->id }}"
                data-name="{{ $availableLocation->name }}"
                onclick="redirectToLocation({{ $availableLocation->id }})" />
        @endforeach

        @foreach ($character->unvisitedLocations() as $unvisitedLocation)
            <image class="svg-icon lock" href="{{ asset('storage/images/icons/unknown.png') }}"
                x="{{ $unvisitedLocation->x - 15 }}" y="{{ $unvisitedLocation->y - 15 }}" width="30"
                height="30" />
        @endforeach

        {{-- Current --}}

        @if ($character->currentLocation())
            <image class="svg-icon" href="{{ asset('storage/images/icons/char.png') }}"
                x="{{ $character->currentLocation()->x - 15 }}" y="{{ $character->currentLocation()->y - 25 }}"
                width="30" height="30" />
        @endif


        {{-- @php
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
            @endforeach --}}
    </g>
</svg>

@section('top-content')
    {{-- <div class="flex-col-13"> --}}
        <div class="frame flex-row-13 ai-center font-sm">

        <button class="icon" onclick="showCurrentLocation()" data-tooltip="Текущая локация">
            @component('components.icon', ['name' => 'marker', 'size' => 28, 'color' => 'FFFFFF'])
            @endcomponent
        </button>

        <button class="icon" onclick="fitMapToView()" data-tooltip="Все локации">
            @component('components.icon', ['name' => 'address', 'size' => 28, 'color' => 'FFFFFF'])
            @endcomponent
        </button>

        <button class="icon" onclick="openFullscreen()" data-tooltip="На весь экран">
            @component('components.icon', ['name' => 'full-screen--v1', 'size' => 28, 'color' => 'FFFFFF'])
            @endcomponent
        </button>

            <span class="flex grow"></span>

        <div class="color-second" id="cursor-coordinates" data-default-x="{{ $character->currentLocation()->x }}"
            data-default-y="{{ $character->currentLocation()->y }}" class="font-sm color-second">
            X: {{ $character->currentLocation()->x }}, Y: {{ $character->currentLocation()->y }}
        </div>
    </div>
@endsection

{{-- <div class="flex-row-8 ai-center">
    <div class="flex grow">
        <div id="cursor-coordinates" data-default-x="{{ $character->currentLocation()->x }}"
            data-default-y="{{ $character->currentLocation()->y }}" class="font-sm color-second">
            X: {{ $character->currentLocation()->x }}, Y: {{ $character->currentLocation()->y }}
        </div>
    </div>

    <div class="flex-row-8">
        <button class="icon" onclick="resetZoom()" data-tooltip="Сброс масштаба">
                @component('components.icon', ['name' => 'find-and-replace', 'size' => 28, 'color' => 'FFFFFF'])
                @endcomponent
            </button>

        <button class="icon" onclick="showCurrentLocation()" data-tooltip="Текущая локация">
            @component('components.icon', ['name' => 'marker', 'size' => 28, 'color' => 'FFFFFF'])
            @endcomponent
        </button>

        <button class="icon" onclick="fitMapToView()" data-tooltip="Все локации">
            @component('components.icon', ['name' => 'address', 'size' => 28, 'color' => 'FFFFFF'])
            @endcomponent
        </button>

        <button class="icon" onclick="openFullscreen()" data-tooltip="На весь экран">
            @component('components.icon', ['name' => 'full-screen--v1', 'size' => 28, 'color' => 'FFFFFF'])
            @endcomponent
        </button>
    </div>
</div> --}}

<script>
    function updateCoordinatesDisplay(x, y) {
        document.getElementById('cursor-coordinates').innerText = `X: ${x}, Y: ${y}`;
    }

    function redirectToLocation(locationId) {
        // Создаём форму для перехода
        const form = document.createElement('form');
        form.action = "{{ route('transitions.store') }}";
        form.method = 'POST';

        // Добавляем скрытое поле с id локации
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'location_id';
        input.value = locationId;

        // Добавляем CSRF токен
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';

        form.appendChild(input);
        form.appendChild(csrfInput);

        // Отправляем форму
        document.body.appendChild(form);
        form.submit();
    }
</script>

<script>
    const svg = document.getElementById('map-svg');
    const map = document.getElementById('map');
    let scale = 1;
    let panX = 0,
        panY = 0;
    let isPanning = false;
    let startX, startY;


    const currentLocationCoords = {
        x: {{ $character->currentLocation()->x }},
        y: {{ $character->currentLocation()->y }}
    };

    window.addEventListener('load', () => {
        showCurrentLocation();
    });

    function showCurrentLocation() {
        resetZoom();
        const svgRect = svg.getBoundingClientRect();
        const centerX = svgRect.width / 2
        const centerY = svgRect.height / 2;

        panX = centerX - currentLocationCoords.x * scale;
        panY = centerY - currentLocationCoords.y * scale;

        map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
    }

    function resetZoom() {
        const svgRect = svg.getBoundingClientRect();
        const centerX = svgRect.width / 2;
        const centerY = svgRect.height / 2;

        const pt = svg.createSVGPoint();
        pt.x = centerX;
        pt.y = centerY;

        const cursor = pt.matrixTransform(svg.getScreenCTM().inverse());

        // Центрировать на той же точке, но с масштабом 1
        scale = 1;
        panX = centerX - cursor.x * scale;
        panY = centerY - cursor.y * scale;

        map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
    }

    function fitMapToView() {
        const bbox = map.getBBox(); // Получаем границы карты
        const svgRect = svg.getBoundingClientRect();

        const widthScale = svgRect.width / bbox.width;
        const heightScale = svgRect.height / bbox.height;
        scale = Math.min(widthScale, heightScale) * 0.9; // Немного уменьшаем, чтобы были отступы

        panX = (svgRect.width / 2) - (bbox.x + bbox.width / 2) * scale;
        panY = (svgRect.height / 2) - (bbox.y + bbox.height / 2) * scale;

        map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
    }

    function openFullscreen() {
        const elem = document.getElementById('map-svg');
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { // для Safari
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { // для IE11
            elem.msRequestFullscreen();
        }
    }

    // Масштабирование с учётом позиции курсора
    svg.addEventListener('wheel', function(e) {
        e.preventDefault();
        const zoom = e.deltaY < 0 ? 1.1 : 0.9;

        const pt = svg.createSVGPoint();
        pt.x = e.clientX;
        pt.y = e.clientY;

        const cursor = pt.matrixTransform(svg.getScreenCTM().inverse());

        panX = cursor.x - (cursor.x - panX) * zoom;
        panY = cursor.y - (cursor.y - panY) * zoom;

        scale *= zoom;

        map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
    });

    // Панорамирование мышью
    svg.addEventListener('mousedown', function(e) {
        isPanning = true;
        startX = e.clientX;
        startY = e.clientY;
    });

    svg.addEventListener('mousemove', function(e) {
        if (!isPanning) return;
        const dx = e.clientX - startX;
        const dy = e.clientY - startY;
        panX += dx;
        panY += dy;
        startX = e.clientX;
        startY = e.clientY;
        map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
    });

    svg.addEventListener('mouseup', () => isPanning = false);
    svg.addEventListener('mouseleave', () => isPanning = false);

    svg.addEventListener('mousemove', function(e) {
        const pt = svg.createSVGPoint();
        pt.x = e.clientX;
        pt.y = e.clientY;
        const cursor = pt.matrixTransform(svg.getScreenCTM().inverse());

        const x = Math.round((cursor.x - panX) / scale);
        const y = Math.round((cursor.y - panY) / scale);

        updateCoordinatesDisplay(x, y);

        if (!isPanning) return;
        const dx = e.clientX - startX;
        const dy = e.clientY - startY;
        panX += dx;
        panY += dy;
        startX = e.clientX;
        startY = e.clientY;
        map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
    });
    svg.addEventListener('mouseleave', () => {
        const el = document.getElementById('cursor-coordinates');
        updateCoordinatesDisplay(el.dataset.defaultX, el.dataset.defaultY);
    });

    window.addEventListener('DOMContentLoaded', () => {
        const el = document.getElementById('cursor-coordinates');
        updateCoordinatesDisplay(el.dataset.defaultX, el.dataset.defaultY);
    });
</script>
