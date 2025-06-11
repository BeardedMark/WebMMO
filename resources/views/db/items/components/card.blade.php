@component('components.context-menu', [
    'menuStyle' => 'min-width: 300px; max-width: 400px;',
])
    @slot('trigger')
        <img src="{{ $item->getModel()->getImageUrl() }}"
            class="img-fill rarity-{{ ceil(count($item->getModifierInstances())) }}">
        @if ($item->getStack() > 1)
            <small class="" style="position: absolute; left: 0; right: 0; bottom: 0; text-align: end; margin: 1px;">
                x{{ $item->getStack() }}
            </small>
        @endif
    @endslot

    <div class="flex-row-8">
        @component('db.items.components.link', ['item' => $item->getModel()])
        @endcomponent

        <p class="flex-grow"></p>

        @if ($item->isEquipment())
            <span class="color-brand font-sm" data-tooltip="Уровень предмета. Усиливает модификаторы">
                {{ $item->getLevel() . ' ур' }}
            </span>
        @endif
    </div>

    <div class="flex-row-5 jc-end">
        @if (count($item->getModel()->usedInCrafts()) > 0)
            @component('components.icon', [
                'size' => 21,
                'name' => 'Production-order',
                'color' => 'FFFFFF',
                'tooltip' => 'Используется в ' . count($item->getModel()->usedInCrafts()) . ' рецепт.',
                'class' => 'icon',
            ])
            @endcomponent
        @endif

        @if (count($item->getModel()->getCraftItems()) > 0)
            @component('components.icon', [
                'size' => 21,
                'name' => 'open-parcel',
                'color' => 'FFFFFF',
                'tooltip' => 'Состоит из ' . count($item->getModel()->getCraftItems()) . ' предм.',
                'class' => 'icon',
            ])
            @endcomponent
        @endif

        @component('components.icon', [
            'size' => 21,
            'name' => 'weight',
            'color' => 'FFFFFF',
            'tooltip' => 'Общий вес ' . $item->getWeight() . ' кг',
            'class' => 'icon',
        ])
        @endcomponent
    </div>

    <div class="flex jc-center pad-13">
        <div class="img-contain" style="width: 150px; height: 150px;">
            <img src="{{ $item->getModel()->getImageUrl() }}"
                class="img-fill rarity-{{ ceil(count($item->getModifierInstances())) }}">
        </div>
    </div>

    @if ($item->hasModifiers())
        <div class="flex-col font-sm">
            @foreach ($item->getSummedModifiers() as $mod)
                @component('components.stat', ['name' => $mod->getName(), 'value' => $mod->getValueTitle()])
                @endcomponent
            @endforeach
        </div>
    @endif

    <form method="POST" class="flex-col-8">
        @csrf
        <input type="hidden" name="uuid" value="{{ $item->getUuid() }}">
        <input type="hidden" name="from_container_type" value="{{ $fromContainer }}">
        <input type="hidden" name="from_container_id" value="{{ $fromId }}">
        <input type="hidden" name="to_container_type" value="{{ $toContainer }}">
        <input type="hidden" name="to_container_id" value="{{ $toId }}">


        <div class="flex-row ai-center font-sm @if ($item->getStack() <= 1) d-none @endif">
            {{-- <button type="button" class="button" onclick="setStack('{{ $item->getUuid() }}', 1)">min</button> --}}
            <button type="button" class="button" onclick="changeStack('{{ $item->getUuid() }}', -1)">−1</button>

            <input id="stack-input-{{ $item->getUuid() }}" class="input text-center font-sm flex-grow" type="number"
                name="stack" value="{{ $item->getStack() }}" min="1" max="{{ $item->getStack() }}">

            <button type="button" class="button" onclick="changeStack('{{ $item->getUuid() }}', +1)">+1</button>
            {{-- <button type="button" class="button"
                onclick="setStack('{{ $item->getUuid() }}', {{ $item->getStack() }})">max</button> --}}
        </div>

        {{-- <div class="flex-row ai-center font-sm @if ($item->getStack() <= 1) d-none @endif">
            <button type="button" class="button w-100" onclick="changeStack('{{ $item->getUuid() }}', -10)">−10</button>
            <button type="button" class="button w-100" onclick="changeStack('{{ $item->getUuid() }}', -1)">−1</button>

        <input type="range" id="stack-range-{{ $item->getUuid() }}" name="stack" min="1"
            max="{{ $item->getStack() }}" value="{{ $item->getStack() }}" />

            <button type="button" class="button w-100" onclick="changeStack('{{ $item->getUuid() }}', +1)">+1</button>
            <button type="button" class="button w-100" onclick="changeStack('{{ $item->getUuid() }}', +10)">+10</button>
        </div> --}}


        <p class="flex-col font-sm">
            @if ($item->isDisassemble())
                <button class="link" type="submit"
                    formaction="{{ route('items.disassemble', ['uuid' => $item->getUuid()]) }}">Разобрать</button>
            @endif

            @if ($item->isEquipment())
                @if ($item->isEquipped())
                    <button class="link" type="submit" formaction="{{ route('items.unequip') }}">Снять</button>
                @else
                    <button class="link" type="submit" formaction="{{ route('items.equip') }}">Экипировать</button>
                @endif
            @endif

            <button class="link" type="submit" formaction="{{ route('items.move') }}">Переместить</button>
        </p>
    </form>

    @push('scripts')
        <script>
            function setStack(uuid, delta) {
                const input = document.getElementById('stack-input-' + uuid);
                input.value = delta;
            }

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
