<div class="frame flex-col-13">
    <div class="flex-col">
        @component('characters.components.line', compact('character'))
        @endcomponent

        {{-- <small>{{ $character->currentLocation()->getTitle() }}</small>
        <small>{{ $character->getExpiriance() }}</small> --}}
    </div>
</div>
