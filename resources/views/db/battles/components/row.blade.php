<div class="row g-1">
    @foreach ($battles as $battle)
        <div class="col-6">
            @component('db.battles.frames.card', compact('battle'))
            @endcomponent
        </div>
    @endforeach
</div>
