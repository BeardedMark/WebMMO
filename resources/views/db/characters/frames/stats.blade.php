
<div class="frame flex-row-13">
    <p class="flex-col ai-center font-center w-100">
        <span>{{ $character->health() }}</span>
        <span class="color-second font-small">Здр</span>
    </p>

    <p class="flex-col ai-center font-center w-100">
        <span>{{ $character->damage() }}</span>
        <span class="color-second font-small">Урн</span>
    </p>

    <p class="flex-col ai-center font-center w-100">
        <span>{{ $character->defense() }}</span>
        <span class="color-second font-small">Защ</span>
    </p>

    <p class="flex-col ai-center font-center w-100">
        <span>{{$character->getTotalWeight()}}/{{$character->maxWeight()}}</span>
        <span class="color-second font-small">Вес</span>
    </p>

    <p class="flex-col ai-center font-center w-100">
        <span>{{ $character->strength() }}</span>
        <span class="color-second font-small">Сил</span>
    </p>

    <p class="flex-col ai-center font-center w-100">
        <span>{{ $character->agility() }}</span>
        <span class="color-second font-small">Лов</span>
    </p>

    <p class="flex-col ai-center font-center w-100">
        <span>{{ $character->intelligence() }}</span>
        <span class="color-second font-small">Инт</span>
    </p>
</div>
