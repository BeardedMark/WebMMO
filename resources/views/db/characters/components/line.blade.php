<p class="flex-row-8 w-100">
    <span class="flex-row-8 ai-center">
        @component('db.characters.components.link', compact('character'))
        @endcomponent

        <span class="color-second font-sm">{{ $character->getOnlineTitle() }}</span>
    </span>

    <span class="flex grow"></span>

    <span class="color-second font-sm">{{ $character->getExperience() }} оп</span>
    <span class="color-brand font-sm">{{ $character->getLevel() }} ур</span>
</p>
