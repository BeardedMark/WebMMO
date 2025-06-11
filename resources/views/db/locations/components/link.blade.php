<a class="link" href="{{ route('locations.show', $location) }}" data-tooltip="{{ $location->description }}">
    {{ $location->getTitle() }}
</a>
