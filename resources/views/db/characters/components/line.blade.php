<p class="flex-row-8 w-100">
    @component('db.characters.components.link', compact('character'))
    @endcomponent
    <span class="flex grow"></span>
    {{-- <small class="color-second">{{ $character->user->login }}</small> --}}
    <small>{{ $character->getStatus() }}</small>
    <small class="color-brand">{{ $character->getLevel() }} ур</small>
</p>
