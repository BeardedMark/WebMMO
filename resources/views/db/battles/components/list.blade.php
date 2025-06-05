
<div class="flex-col-5">
    @foreach ($battles as $battle)
        @component('db.battles.components.line', compact('battle'))
        @endcomponent
    @endforeach
</div>
