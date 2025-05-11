
<div id="location-{{ $location->id }}" class="frame flex-col-13">
    <img width="100%" src="{{ $location->getImageUrl() }}" alt="">

    <div class="flex-col">
        @component('locations.components.line', compact('location'))
        @endcomponent
    </div>
</div>
