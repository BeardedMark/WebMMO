
<div class="flex-col">
    @foreach ($enemies as $enemy)
        @component('enemies.components.line', compact('enemy'))
        @endcomponent
    @endforeach
</div>
