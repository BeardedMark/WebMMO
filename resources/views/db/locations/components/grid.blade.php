<div class="row g-4">
    @foreach ($locations as $location)
        <div class="col-3">
            @component('db.locations.components.card', compact('location'))
            @endcomponent
        </div>
    @endforeach
</div>
