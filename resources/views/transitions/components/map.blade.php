<div class="flex-col-13">

    <svg class="svg-map" id="map-svg" width="100%" height="500" xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="map" transform="translate(0,0) scale(1)">
            <image class="svg-icon lock" href="{{ asset('storage/img/islands/201173.png') }}" x="0" y="0" width="1024"
                height="1024" />

            <defs>
                <mask id="fog-mask">
                    <g filter="url(#blur)">
                        <rect width="1024" height="1024" fill="white" />

                        @foreach ($currentCharacter->roadsToVisitedLocations() as $road)
                            <line x1="{{ $road->fromLocation->x }}" y1="{{ $road->fromLocation->y }}"
                                x2="{{ $road->toLocation->x }}" y2="{{ $road->toLocation->y }}" stroke="black"
                                stroke-width="200" stroke-linecap="round" />
                        @endforeach

                        @foreach ($currentCharacter->roadsToUnvisitedLocations() as $road)
                            <line x1="{{ $road->fromLocation->x }}" y1="{{ $road->fromLocation->y }}"
                                x2="{{ $road->toLocation->x }}" y2="{{ $road->toLocation->y }}" stroke="black"
                                stroke-width="50" stroke-linecap="round" />
                        @endforeach

                        @if ($currentCharacter->currentLocation())
                            <circle cx="{{ $currentCharacter->currentLocation()->x }}"
                                cy="{{ $currentCharacter->currentLocation()->y }}" r="100" fill="black" />
                        @endif
                    </g>
                </mask>

                <filter id="blur">
                    <feGaussianBlur stdDeviation="15" />
                </filter>
            </defs>

            <rect width="1024" height="1024" fill="rgba(0, 0, 0, 1)" mask="url(#fog-mask)" />

            {{-- @php
                use App\Models\Road;
                use App\Models\Location;
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

            {{-- Roads --}}

            @foreach ($currentCharacter->roadsToUnvisitedLocations() as $road)
                @if ($road->fromLocation && $road->fromLocation)
                    <line class="svg-road unvisited" x1="{{ $road->fromLocation->x }}"
                        y1="{{ $road->fromLocation->y }}" x2="{{ $road->toLocation->x }}"
                        y2="{{ $road->toLocation->y }}" stroke-width="3" />
                @endif
            @endforeach

            @foreach ($currentCharacter->roadsToVisitedLocations() as $road)
                @if ($road->fromLocation && $road->fromLocation)
                    <line class="svg-road visited" x1="{{ $road->fromLocation->x }}" y1="{{ $road->fromLocation->y }}"
                        x2="{{ $road->toLocation->x }}" y2="{{ $road->toLocation->y }}" stroke-width="3" />
                @endif
            @endforeach

            @if ($currentCharacter->currentLocation())
                @foreach ($currentCharacter->availableRoads() as $road)
                    @if ($road->fromLocation && $road->fromLocation)
                        <line class="svg-road available await hidden" x1="{{ $road->fromLocation->x }}"
                            y1="{{ $road->fromLocation->y }}" x2="{{ $road->toLocation->x }}"
                            y2="{{ $road->toLocation->y }}" stroke-width="2" />
                    @endif
                @endforeach
            @endif

            {{-- Locations --}}

            @foreach ($currentCharacter->visitedLocations() as $location)
                <image class="svg-icon" href="{{ asset('storage/img/icons/novisited.png') }}"
                    x="{{ $location->x - 15 }}" y="{{ $location->y - 15 }}" width="30" height="30" />
            @endforeach

            @foreach ($currentCharacter->availableLocations() as $location)
                <image class="await hidden" href="{{ asset('storage/img/icons/unvisited.png') }}"
                    x="{{ $location->x - 15 }}" y="{{ $location->y - 15 }}" width="30" height="30" />

                <circle r="13" fill="transparent" class="svg-icon available await" cx="{{ $location->x }}"
                    cy="{{ $location->y }}" data-id="{{ $location->id }}" data-name="{{ $location->name }}"
                    onclick="redirectToLocation({{ $location->id }})" />
            @endforeach

            @foreach ($currentCharacter->unvisitedLocations() as $location)
                <image class="svg-icon lock" href="{{ asset('storage/img/icons/unknown.png') }}"
                    x="{{ $location->x - 15 }}" y="{{ $location->y - 15 }}" width="30" height="30" />
            @endforeach

            @if (auth()->user()->hideoutLocations())
                @foreach (auth()->user()->hideoutLocations() as $location)
                    <image class="svg-icon lock" href="{{ asset('storage/img/icons/home.png') }}"
                        x="{{ $location->x - 15 }}" y="{{ $location->y - 15 }}" width="30" height="30" />
                @endforeach
            @endif

            {{-- Current --}}

            @foreach ($currentCharacter->latestTransition->getItems() as $item)
                @php
                    $angle = (rand(0, 360) * M_PI) / 180;
                    $distance = rand(20, 50);
                    $offsetX = cos($angle) * $distance;
                    $offsetY = sin($angle) * $distance;

                    $itemX = $currentCharacter->currentLocation()->x + $offsetX;
                    $itemY = $currentCharacter->currentLocation()->y + $offsetY;
                @endphp

                <image class="svg-icon lock" href="{{ $item->item->getImageUrl() }}" x="{{ $itemX - 10 }}"
                    y="{{ $itemY - 10 }}" width="20" height="20" />
            @endforeach

            @if ($currentCharacter->currentLocation())
                <image class="svg-icon" href="{{ asset('storage/img/icons/char.png') }}"
                    x="{{ $currentCharacter->currentLocation()->x - 15 }}"
                    y="{{ $currentCharacter->currentLocation()->y - 25 }}" width="30" height="30" />
            @endif
        </g>
    </svg>

    <div class="flex-row-8">
        <div class="flex-row-8">
            <button class="icon" onclick="showCurrentLocation()" data-tooltip="Текущая локация">
                @component('components.icon', ['name' => 'marker', 'size' => 21, 'color' => 'BAC7E3'])
                @endcomponent
            </button>

            <button class="icon" onclick="fitMapToView()" data-tooltip="Все локации">
                @component('components.icon', ['name' => 'address', 'size' => 21, 'color' => 'BAC7E3'])
                @endcomponent
            </button>


            <button class="icon" onclick="openFullscreen()" data-tooltip="На весь экран">
                @component('components.icon', ['name' => 'full-screen--v1', 'size' => 21, 'color' => 'BAC7E3'])
                @endcomponent
            </button>
        </div>
    </div>
</div>

<script>
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

    @if ($currentCharacter->currentLocation())

        const currentLocationCoords = {
            x: {{ $currentCharacter->currentLocation()->x }},
            y: {{ $currentCharacter->currentLocation()->y }}
        };
        // Центрируем SVG по текущей локации
        window.addEventListener('load', () => {
            showCurrentLocation();
        });

        function showCurrentLocation() {
            const svgRect = svg.getBoundingClientRect();
            const centerX = svgRect.width / 2
            const centerY = svgRect.height / 2;

            panX = centerX - currentLocationCoords.x * scale;
            panY = centerY - currentLocationCoords.y * scale;

            map.setAttribute('transform', `translate(${panX}, ${panY}) scale(${scale})`);
        }
    @endif

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
</script>
