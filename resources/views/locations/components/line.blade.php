<p class="flex-row-8">
    <a class="link" href="{{ route('locations.show', $location) }}">{{ $location->getTitle() }}</a>

    {{-- <span class="color-second">#{{ $location->id }}</span> --}}

    <span class="flex grow"></span>
    {{-- <span class="color-second">[{{ $location->x }}:{{ $location->y }}]</span> --}}
    <small>{{ count($location->charactersOnLocation()) }} чел</small>
    <small class="color-brand">{{ $location->getLevel() }} ур</small>
</p>
