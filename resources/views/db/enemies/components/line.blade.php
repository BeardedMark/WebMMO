
<div class="row g-1">
    <div class="col">
        @component('db.enemies.components.link', compact('enemy'))
        @endcomponent
    </div>

    <div class="col-1 text-center">
        <small class="color-second">{{ $enemy->getMinLevel() ?? "–" }}</small>
    </div>

    <div class="col-1 text-center">
        <small class="color-second">{{ $enemy->getMaxLevel() ?? "–" }}</small>
    </div>

    <div class="col-1 text-end">
        <small class="color-second">{{ $enemy->getDanger() }}</small>
    </div>

    <div class="col-1 text-end">
        <small class="color-second">{{ $enemy->getSpawnChance() }} %</small>
    </div>
</div>
