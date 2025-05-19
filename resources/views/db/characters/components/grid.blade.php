<div class="row g-4">
    @foreach ($characters as $character)
    <div class="col-4">
            @component('db.characters.frames.card', compact('character'))
            @endcomponent
        </div>
    @endforeach
</div>
