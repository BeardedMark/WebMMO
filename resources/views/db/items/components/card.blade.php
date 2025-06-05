<div style="display: inline-block; position: relative;">

    {{-- Клик-зона отдельно --}}
    <div onclick="toggleContextMenu(this)" style="cursor: pointer;"
        class="rarity-{{ ceil(count($item->getModifierInstances())) }}">
        <img src="{{ $item->getModel()->getImageUrl() }}" class="img-fill">
        @if ($item->getStack() > 1)
            <small class="" style="position: absolute; left: 0; right: 0; bottom: 0; text-align: end; margin: 1px;">
                x{{ $item->getStack() }}
            </small>
        @endif
    </div>

    {{-- Само меню — теперь не входит в область клика --}}
    <div class="context-menu frame"
        style="display: none; position: absolute; top: 101%; left: 0; min-width: 300px; max-width: 400px; z-index:999">
        <form method="POST" class="flex-col-13">
            @csrf

            <div class="flex-row-8">
            @component('db.items.components.link', ['item' => $item->getModel()])
            @endcomponent

                <span class="flex grow"></span>
                <span class="color-brand font-sm">1 ур</span>
            </div>


            @if ($item->hasModifiers())
                <div class="flex-col color-second">
                    @foreach ($item->getSummedModifiers() as $mod)
                        @component('components.stat', ['name' => $mod->getName(), 'value' => $mod->getValueTitle()])
                        @endcomponent
                    @endforeach
                </div>
            @endif

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
                        formaction="{{ route('items.disassemble', ['uuid' => $item->getUuid()]) }}">Разобрать</button>
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

            // Сброс положения
            menu.style.top = '101%';
            menu.style.bottom = 'auto';
            menu.style.left = '0';
            menu.style.right = 'auto';

            const rect = menu.getBoundingClientRect();
            const padding = 8;

            // Если выходит за нижнюю границу — показать сверху
            if (rect.bottom > window.innerHeight - padding) {
                menu.style.top = 'auto';
                menu.style.bottom = '101%';
            }

            // Если выходит за правую границу — сместить влево
            if (rect.right > window.innerWidth - padding) {
                menu.style.left = 'auto';
                menu.style.right = '0';
            }

            // Если выходит за левую границу — выровнять по левому краю
            if (rect.left < padding) {
                menu.style.left = `${padding}px`;
            }
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
