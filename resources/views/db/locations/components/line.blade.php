<p class="flex-row-8 ai-center">
    <a class="link" href="{{ route('locations.show', $location) }}">{{ $location->getTitle() }}</a>

    {{-- <span class="color-second">#{{ $location->id }}</span> --}}

    <span class="flex grow"></span>
    <span class="color-second font-small">{{ count($location->charactersOnLocation()) }} чел</span>
    <span class="font-small">{{ $location->getSize() }} разм</span>
    <span class="color-brand font-small">{{ $location->getLevel() }} ур</span>
</p>
