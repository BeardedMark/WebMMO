<div id="location-{{ $location->getId() }}" class="frame flex-col-13 h-100">
    @component('db.locations.components.line', compact('location'))
    @endcomponent

    @if ($location->getImageUrl())
        <div class="img-contain">
            <img src="{{ $location->getImageUrl() }}" alt="{{ $location->getTitle() }}">
        </div>
    @endif

    {{-- @component('db.locations.components.stats', compact('location'))
    @endcomponent --}}
</div>
