<div class="flex-col-13">


    <svg class="svg-map" id="map-svg" width="100%" height="400" xmlns="http://www.w3.org/2000/svg">
        <g id="map" transform="translate(0,0) scale(1)">
            @if ($currentCharacter->currentLocation())
                <circle r="100" class="svg-area" cx="{{ $currentCharacter->currentLocation()->x }}"
                    cy="{{ $currentCharacter->currentLocation()->y }}"
                    data-id="{{ $currentCharacter->currentLocation()->id }}"
                    data-name="{{ $currentCharacter->currentLocation()->name }}" />
            @endif

            {{-- Unvisited --}}
            @foreach ($currentCharacter->roadsToUnvisitedLocations() as $road)
                @if ($road->fromLocation && $road->fromLocation)
                    <line class="svg-road lock" x1="{{ $road->fromLocation->x }}" y1="{{ $road->fromLocation->y }}"
                        x2="{{ $road->toLocation->x }}" y2="{{ $road->toLocation->y }}" stroke-width="2" />
                @endif
            @endforeach

            {{-- @foreach ($currentCharacter->unvisitedLocations() as $location)
                <circle class="svg-location unvisited" r="{{ $location->getSize() }}" cx="{{ $location->x }}" cy="{{ $location->y }}"
                    data-id="{{ $location->id }}" data-name="{{ $location->name }}" />
            @endforeach --}}

            {{-- Visited --}}
            @foreach ($currentCharacter->roadsToVisitedLocations() as $road)
                @if ($road->fromLocation && $road->fromLocation)
                    <line class="svg-road visited" x1="{{ $road->fromLocation->x }}" y1="{{ $road->fromLocation->y }}"
                        x2="{{ $road->toLocation->x }}" y2="{{ $road->toLocation->y }}" stroke-width="3" />
                @endif
            @endforeach

            @foreach ($currentCharacter->visitedLocations() as $location)
                <circle class="svg-location visited" r="{{ $location->getSize() }}" cx="{{ $location->x }}" cy="{{ $location->y }}"
                    data-id="{{ $location->id }}" data-name="{{ $location->name }}" />
            @endforeach

            {{-- Current --}}
            @if ($currentCharacter->currentLocation())
                @foreach ($currentCharacter->availableRoads() as $road)
                    @if ($road->fromLocation && $road->fromLocation)
                        <line class="svg-road available await" x1="{{ $road->fromLocation->x }}"
                            y1="{{ $road->fromLocation->y }}" x2="{{ $road->toLocation->x }}"
                            y2="{{ $road->toLocation->y }}" stroke-width="1" />

                        {{-- <text x="{{ $road->getCenterCoordinates()['x'] }}"
                            y="{{ $road->getCenterCoordinates()['y'] }}">{{ $road->getDistance() }}</text> --}}
                    @endif
                @endforeach
            @endif

            @foreach ($currentCharacter->availableLocations() as $location)
                <circle r="3" class="svg-location available await" cx="{{ $location->x }}" cy="{{ $location->y }}"
                    data-id="{{ $location->id }}" data-name="{{ $location->name }}"
                    onclick="redirectToLocation({{ $location->id }})" />
            @endforeach

            @if ($currentCharacter->currentLocation())
                <circle r="5" class="svg-location current" cx="{{ $currentCharacter->currentLocation()->x }}"
                    cy="{{ $currentCharacter->currentLocation()->y }}"
                    data-id="{{ $currentCharacter->currentLocation()->id }}"
                    data-name="{{ $currentCharacter->currentLocation()->name }}" />
            @endif


        </g>
    </svg>
    <div class="flex-row-8">
        <div class="flex-row-8">
            <button class="icon" onclick="showCurrentLocation()" data-tooltip="Текущая локация">
                @component('elements.icon', ['name' => 'marker', 'size' => 21, 'color' => 'BAC7E3'])
                @endcomponent
            </button>

            <button class="icon" onclick="fitMapToView()" data-tooltip="Все локации">
                @component('elements.icon', ['name' => 'address', 'size' => 21, 'color' => 'BAC7E3'])
                @endcomponent
            </button>


            <button class="icon" onclick="openFullscreen()" data-tooltip="На весь экран">
                @component('elements.icon', ['name' => 'full-screen--v1', 'size' => 21, 'color' => 'BAC7E3'])
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
        input.name = 'to_location_id';
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
