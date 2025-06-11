<svg class="svg-map" id="map-svg" width="100%" height="500" xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink">
    <g id="map" transform="translate(0,0) scale(1)">
        <defs>
            @include('db.transitions.components.fog')
        </defs>

        @include('db.transitions.components.world')
        @include('db.transitions.components.roads')
        @include('db.transitions.components.locations')
        {{-- @include('db.transitions.components.cheat') --}}

    </g>
</svg>

@push('scripts')
    <script>
        window.mapConfig = {
            formAction: "{{ route('transitions.store') }}",
            csrfToken: "{{ csrf_token() }}",
            defaultX: {{ $character->currentLocation()->x }},
            defaultY: {{ $character->currentLocation()->y }}
        };
    </script>

    <script src="{{ asset('js/domains/map.js') }}"></script>
@endpush
