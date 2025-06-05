<div class="frame flex-col-13">
    <div id="character-card">
        <div class=" flex-col-8">
            @component('db.characters.components.line', compact('character'))
            @endcomponent

            <div class="flex-col-5">
                {{-- <p class="health" style="width: {{ $character->getHealthPercent() }}%"></p>
                <p class="experience" style="width: {{ $character->getLevelPercent() }}%"></p> --}}
                <p class="health" id="character-health-bar-{{ $character->id }}"
                    style="width: {{ $character->getHealthPercent() }}%"></p>
                <p class="experience" id="character-experience-bar-{{ $character->id }}"
                    style="width: {{ $character->getLevelPercent() }}%"></p>
            </div>
        </div>
    </div>

    <script>
        setInterval(function() {
            fetch('{{ route('characters.values') }}')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('character-health-bar-{{ $character->id }}').style.width = data
                        .health_percent + '%';
                    document.getElementById('character-experience-bar-{{ $character->id }}').style.width = data
                        .level_percent + '%';
                });
        }, 1000);
    </script>

    {{-- <script>
        setInterval(function() {
            fetch('{{ route('characters.card') }}')
                .then(response => response.text())
                .then(html => {
                    const el = document.getElementById('character-card');
                    el.innerHTML = html;
                });
        }, 1000);
    </script> --}}

    @component('db.characters.frames.equip', compact('character'))
    @endcomponent


    <div class=" flex-row-13">
        <p class="flex-col ai-center font-center w-100">
            <span>{{ $character->getHealth() }}</span>
            <span class="color-second font-sm">Здр</span>
        </p>

        <p class="flex-col ai-center font-center w-100">
            <span>{{ $character->getDamage() }}</span>
            <span class="color-second font-sm">Урн</span>
        </p>

        <p class="flex-col ai-center font-center w-100">
            <span>{{ $character->getDefence() }}</span>
            <span class="color-second font-sm">Защ</span>
        </p>

        <p class="flex-col ai-center font-center w-100">
            <span>{{ $character->getTotalWeight() }}/{{ $character->maxWeight() }}</span>
            <span class="color-second font-sm">Вес</span>
        </p>

        <p class="flex-col ai-center font-center w-100">
            <span>{{ $character->getStrength() }}</span>
            <span class="color-second font-sm">Сил</span>
        </p>

        <p class="flex-col ai-center font-center w-100">
            <span>{{ $character->getAgility() }}</span>
            <span class="color-second font-sm">Лов</span>
        </p>

        <p class="flex-col ai-center font-center w-100">
            <span>{{ $character->getIntelligence() }}</span>
            <span class="color-second font-sm">Инт</span>
        </p>
    </div>

</div>
