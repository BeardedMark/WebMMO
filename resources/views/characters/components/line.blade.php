<p class="flex-row-8">
    @component('characters.components.link', compact('character'))
    @endcomponent
    <span class="flex grow"></span>
    <small class="color-second">{{ $character->currentLocation()->getTitle() }}</small>
    <small>{{ $character->getStatus() }}</small>
    <small class="color-brand">{{ $character->getLevel() }} ур</small>
</p>
