<div class="row g-4">
    @foreach ($characters as $character)
    <div class="col-3">
            @component('characters.components.card', compact('character'))
            @endcomponent
        </div>
    @endforeach
</div>
