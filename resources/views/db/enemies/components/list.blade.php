
<div class="flex-col">
    @foreach ($enemies as $enemy)
        @component('db.enemies.components.line', compact('enemy'))
        @endcomponent
    @endforeach
</div>
