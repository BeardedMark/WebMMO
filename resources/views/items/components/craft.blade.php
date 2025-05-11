
<div class="frame flex-col">
    @foreach ($items as $item)
        @component('items.components.line', compact('item'))
        @endcomponent
    @endforeach
</div>
