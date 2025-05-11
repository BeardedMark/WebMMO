<div class="row g-4">
    @foreach ($locations as $location)
        <div class="col-4">
            @component('locations.components.card', compact('location'))
            @endcomponent
        </div>
    @endforeach
</div>
