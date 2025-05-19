<div style="display: inline-block; position: relative;">

    {{-- Клик-зона отдельно --}}
    <div onclick="toggleContextMenu(this)" style="cursor: pointer; padding: 8px;"
        class="rarity-{{ ceil(count($item->getModifiers())) }}">
        <img src="{{ $item->getModel()->getImageUrl() }}" class="img-fill">
        @if ($item->getStack() > 1)
            <small class="" style="position: absolute; left: 0; right: 0; bottom: 0; text-align: end; margin: 1px;">
                x{{ $item->getStack() }}
            </small>
        @endif
    </div>

    {{-- Само меню — теперь не входит в область клика --}}
    <div class="context-menu frame"
        style="display: none; position: absolute; top: 101%; left: 0; min-width: 250px; max-width: 400px; z-index:999">
        <form method="POST" class="flex-col-13">
            @csrf
            @component('db.items.components.link', ['item' => $item->getModel()])
            @endcomponent

            @if ($item->haveProperties())
                <div class="flex-col">
                    @foreach ($item->getProperties() as $prop)
                        @component('components.stat', ['name' => $prop['name'], 'value' => $prop['value']])
                        @endcomponent
                    @endforeach
                </div>
            @endif

            @if ($item->haveModifiers())
                <div class="flex-col">
                    @foreach ($item->getModifiers() as $mod)
                        @component('components.stat', ['name' => $mod['name'], 'value' => $mod['value']])
                        @endcomponent
                    @endforeach
                </div>
            @endif

            @component('components.stat', ['name' => 'Общий вес', 'value' => $item->getWeight() . ' кг'])
            @endcomponent

            <input type="hidden" name="uuid" value="{{ $item->getUuid() }}">
            <input type="hidden" name="from_container_type" value="{{ $fromContainer }}">
            <input type="hidden" name="from_container_id" value="{{ $fromId }}">
            <input type="hidden" name="to_container_type" value="{{ $toContainer }}">
            <input type="hidden" name="to_container_id" value="{{ $toId }}">
            <input class="input w-100" type="number" name="stack" value="{{ $item->getStack() }}" min="1"
                max="{{ $item->getStack() }}">

            <small class="flex-col">
                <button class="link" type="submit" formaction="{{ route('items.move') }}">Переместить</button>

                @if ($item->isEquipment())
                    <button class="link" type="submit" formaction="{{ route('items.equip') }}">Экипировать</button>
                @endif

                @if ($item->isDisassemble())
                    <button class="link" type="submit"
                        formaction="{{ route('items.disassemble') }}">Разобрать</button>
                @endif
            </small>
        </form>
    </div>
</div>


<script>
    function toggleContextMenu(trigger) {
        const wrapper = trigger.parentElement;
        const menu = wrapper.querySelector('.context-menu');
        const isVisible = menu.style.display === 'block';

        // Скрыть все
        document.querySelectorAll('.context-menu').forEach(m => m.style.display = 'none');

        if (!isVisible) {
            menu.style.display = 'block';
        }
    }

    document.addEventListener('click', function(e) {
        const isInsideMenu = e.target.closest('.context-menu');
        const isTrigger = e.target.closest('[onclick^="toggleContextMenu"]');

        if (!isInsideMenu && !isTrigger) {
            document.querySelectorAll('.context-menu').forEach(m => m.style.display = 'none');
        }
    });
</script>
