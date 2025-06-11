<div class="frame flex-col-13">
    <div class="flex-col-8">
        @component('db.characters.components.line', compact('character'))
        @endcomponent

        <div class="flex-col-5">
            <p class="health" id="character-health-bar-{{ $character->id }}"
                style="width: {{ $character->getHealthPercent() }}%"></p>
            <p class="experience" id="character-experience-bar-{{ $character->id }}"
                style="width: {{ $character->getLevelPercent() }}%"></p>
        </div>

        <div class="flex-row-5 jc-end">
            @component('components.icon', [
                'size' => 21,
                'name' => 'pulse',
                'color' => 'FFFFFF',
                'tooltip' => 'Регенерация ' . $character->getRegen() . ' зд/с',
                'class' => 'icon',
            ])
            @endcomponent

            @component('components.icon', [
                'size' => 21,
                'name' => 'air-element',
                'color' => 'FFFFFF',
                'tooltip' => 'Скорость атаки ' . $character->getAttackSpeed() . ' уд/с',
                'class' => 'icon',
            ])
            @endcomponent

            @component('components.icon', [
                'size' => 21,
                'name' => 'stopwatch',
                'color' => 'FFFFFF',
                'tooltip' => 'Скорость передвижения ' . $character->getMoveSpeed() . ' км/ч',
                'class' => 'icon',
            ])
            @endcomponent
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

    @component('db.characters.frames.equip', compact('character'))
    @endcomponent

    <div class="flex-row-8">
        @component('components.stamp', [
            'note' => 'Урн',
            'header' => $character->getDamage(),
            'tooltip' => 'Урон персонажа',
        ])
        @endcomponent

        @component('components.stamp', [
            'note' => 'Здр',
            'header' => $character->getHealth(),
            'tooltip' => 'Здоровье персонажа',
        ])
        @endcomponent

        @component('components.stamp', [
            'note' => 'Защ',
            'header' => $character->getDefence(),
            'tooltip' => 'Защита персонажа',
        ])
        @endcomponent

        @component('components.stamp', [
            'note' => 'Вес',
            'header' => $character->getTotalWeight() . '/' . $character->maxWeight(),
            'tooltip' => 'Текущий/максимальный переносимый вес',
        ])
        @endcomponent

        @component('components.stamp', [
            'note' => 'Сил',
            'header' => $character->getStrength(),
            'tooltip' => 'Сила персонажа',
        ])
        @endcomponent

        @component('components.stamp', [
            'note' => 'Лов',
            'header' => $character->getAgility(),
            'tooltip' => 'Ловкость персонажа',
        ])
        @endcomponent

        @component('components.stamp', [
            'note' => 'Инт',
            'header' => $character->getIntelligence(),
            'tooltip' => 'Интеллект персонажа',
        ])
        @endcomponent
    </div>
</div>
