
<div class="flex-col">
    @foreach ($containers as $container)
        @component('db.containers.components.line', compact('container'))
        @endcomponent
    @endforeach
</div>
