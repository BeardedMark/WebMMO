<div class="frame flex-col-8">
    @component('db.characters.components.line', compact('character'))
    @endcomponent

    <div class="flex-col-8">
        <p class="health" style="width: {{ $character->getHealthPercent() }}%"></p>
        <p class="experience" style="width: {{ $character->getLevelPercent() }}%"></p>
    </div>
</div>
