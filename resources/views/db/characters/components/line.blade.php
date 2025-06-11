<div class="flex-row-8 ai-center">
    @component('db.characters.components.link', compact('character'))
    @endcomponent

    <p class="flex-grow">
        <span class="color-second font-sm">
            {{ $character->getOnlineTitle() }}
        </span>
    </p>

    <p class="font-sm">
        @component('db.characters.components.timer', compact('character'))
        @endcomponent
    </p>

    {{-- <span
        style="
        color: rgb({{ $character->getAttributesColor()['R'] }}, {{ $character->getAttributesColor()['G'] }}, {{ $character->getAttributesColor()['B'] }});
        filter: drop-shadow(0 0 5px rgb({{ $character->getAttributesColor()['R'] }}, {{ $character->getAttributesColor()['G'] }}, {{ $character->getAttributesColor()['B'] }}));">
        ●</span> --}}

    <span class="color-brand font-sm" data-tooltip="{{ $character->getExperience() }} оп">
        {{ $character->getLevel() }} ур
    </span>
</div>
