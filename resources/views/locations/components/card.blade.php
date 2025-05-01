
<div class="frame flex-col-13">
    <img width="100%" src="{{ $location->getImageUrl() }}" alt="">

    <div class="flex-col">
        @component('locations.components.line', compact('location'))
        @endcomponent

        <small>{{ $location->description }}</small>
    </div>
</div>
