
<div class="flex-col">
    @foreach ($locations as $location)
        @component('locations.components.line', compact('location'))
        @endcomponent
    @endforeach
</div>
