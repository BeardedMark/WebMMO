@component('components.context-menu', [
    'menuStyle' => 'min-width: 300px; max-width: 400px;',
])
    @slot('trigger')
        <img class="img-fill" src="{{ $enemy->getModel()->getImageUrl() }}" style="border-radius: 100%">

        @if ($enemy->getStack() > 1)
            <p class="font-sm" style="position: absolute; left: 0; right: 0; bottom: 0; text-align: end;">
                x{{ $enemy->getStack() }}
            </p>
        @endif
    @endslot

    <div class="flex-row-8">
        @component('db.enemies.components.link', ['enemy' => $enemy->getModel()])
        @endcomponent

        <p class="flex-grow"></p>

        <span class="color-brand font-sm">{{ $enemy->getLevel() }} ур</span>
    </div>

    <div class="flex-row-5 jc-end">
        @component('components.icon', [
            'size' => 21,
            'name' => 'pulse',
            'color' => 'FFFFFF',
            'tooltip' => 'Регенерация ' . $enemy->getRegen() . ' зд/с',
            'class' => 'icon',
        ])
        @endcomponent

        @component('components.icon', [
            'size' => 21,
            'name' => 'air-element',
            'color' => 'FFFFFF',
            'tooltip' => 'Скорость атаки ' . $enemy->getAttackSpeed() . ' уд/с',
            'class' => 'icon',
        ])
        @endcomponent

        @component('components.icon', [
            'size' => 21,
            'name' => 'stopwatch',
            'color' => 'FFFFFF',
            'tooltip' => 'Скорость передвижения ' . $enemy->getMoveSpeed() . ' км/ч',
            'class' => 'icon',
        ])
        @endcomponent
    </div>

    <div class="flex jc-center pad-13">
        <div class="img-contain" style="width: 150px; height: 150px; ">
            <img src="{{ $enemy->getModel()->getImageUrl() }}" class="img-fill" style="border-radius: 100%">
        </div>
    </div>

    <div class="flex-row-8">
        @component('components.stamp', [
            'header' => $enemy->getHealth(),
            'note' => 'Здр',
            'tooltip' => 'Здоровье врага',
        ])
        @endcomponent

        @component('components.stamp', [
            'header' => $enemy->getDamage(),
            'note' => 'Урн',
            'tooltip' => 'Урон врага',
        ])
        @endcomponent

        @component('components.stamp', [
            'header' => $enemy->getDefence(),
            'note' => 'Защ',
            'tooltip' => 'Защита врага',
        ])
        @endcomponent

        @component('components.stamp', [
            'header' => $enemy->getStrength(),
            'note' => 'Сил',
            'tooltip' => 'Сила врага',
        ])
        @endcomponent

        @component('components.stamp', [
            'header' => $enemy->getAgility(),
            'note' => 'Лов',
            'tooltip' => 'Ловкость врага',
        ])
        @endcomponent

        @component('components.stamp', [
            'header' => $enemy->getIntelligence(),
            'note' => 'Инт',
            'tooltip' => 'Интеллект врага',
        ])
        @endcomponent
    </div>

    @if ($enemy->hasModifiers())
        <div class="flex-col font-sm">

            @component('db.modifiers.frames.modifiers', ['modifiers' => $enemy->getModifierInstances()])
            @endcomponent
        </div>
    @endif

    <form method="POST" class="flex-col-13">
        @csrf

        <div class="flex-row-5 ai-center @if ($enemy->getStack() <= 1) d-none @endif">
            <button type="button" class="button" onclick="changeStack('{{ $enemy->getUuid() }}', -10)">−10</button>
            <button type="button" class="button" onclick="changeStack('{{ $enemy->getUuid() }}', -1)">−</button>

            <input id="stack-input-{{ $enemy->getUuid() }}" class="input text-center font-sm flex-grow" type="number"
                name="stack" value="{{ $enemy->getStack() }}" min="1" max="{{ $enemy->getStack() }}">

            <button type="button" class="button" onclick="changeStack('{{ $enemy->getUuid() }}', +1)">+</button>

            <button type="button" class="button" onclick="changeStack('{{ $enemy->getUuid() }}', +10)">+10</button>
        </div>

        <small class="flex-col">
            <button class="link" type="submit"
                formaction="{{ route('enemies.battle', $enemy->getUuid()) }}">Атаковать</button>
        </small>
    </form>

    @push('scripts')
        <script>
            function changeStack(uuid, delta) {
                const input = document.getElementById('stack-input-' + uuid);
                let val = parseInt(input.value, 10) + delta;
                const min = parseInt(input.min, 10);
                const max = parseInt(input.max, 10);
                if (!isNaN(min)) val = Math.max(val, min);
                if (!isNaN(max)) val = Math.min(val, max);
                input.value = val;
            }
        </script>
    @endpush

@endcomponent
