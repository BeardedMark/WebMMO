<div style="display: inline-block; position: relative;">

    {{-- Клик-зона отдельно --}}
    <div onclick="toggleContextMenu(this)" style="cursor: pointer; padding: 8px;">
        <img src="{{ $enemy->getModel()->getImageUrl() }}" width="48" height="48" style="border-radius: 100%">
        @if ($enemy->getStack() > 1)
            <small class="" style="position: absolute; left: 0; right: 0; bottom: 0; text-align: end; margin: 1px;">
                x{{ $enemy->getStack() }}
            </small>
        @endif
    </div>

    {{-- Само меню — теперь не входит в область клика --}}
    <div class="context-menu frame"
        style="display: none; position: absolute; top: 101%; left: 0; min-width: 300px; max-width: 400px; z-index:999">
        <form method="POST" class="flex-col-13">
            @csrf
            <div class="flex-row-8">
                @component('db.enemies.components.link', ['enemy' => $enemy->getModel()])
                @endcomponent

                <span class="flex grow"></span>
                <span class="color-brand font-sm">{{ $enemy->getLevel() }} ур</span>
            </div>

            @if ($enemy->hasModifiers())
                @component('db.modifiers.frames.modifiers', ['modifiers' => $enemy->getModifierInstances()])
                @endcomponent
            @endif

            <div class=" flex-row-13">
                <p class="flex-col ai-center font-center w-100">
                    <span>{{ $enemy->getHealth() }}</span>
                    <span class="color-second font-sm">Здр</span>
                </p>

                <p class="flex-col ai-center font-center w-100">
                    <span>{{ $enemy->getDamage() }}</span>
                    <span class="color-second font-sm">Урн</span>
                </p>

                <p class="flex-col ai-center font-center w-100">
                    <span>{{ $enemy->getDefence() }}</span>
                    <span class="color-second font-sm">Защ</span>
                </p>

                <p class="flex-col ai-center font-center w-100">
                    <span>{{ $enemy->getStrength() }}</span>
                    <span class="color-second font-sm">Сил</span>
                </p>

                <p class="flex-col ai-center font-center w-100">
                    <span>{{ $enemy->getAgility() }}</span>
                    <span class="color-second font-sm">Лов</span>
                </p>

                <p class="flex-col ai-center font-center w-100">
                    <span>{{ $enemy->getIntelligence() }}</span>
                    <span class="color-second font-sm">Инт</span>
                </p>
            </div>


            <input class="input w-100" type="number" name="stack" value="{{ $enemy->getStack() }}" min="1"
                max="{{ $enemy->getStack() }}">

            <small class="flex-col">
                <button class="link" type="submit"
                    formaction="{{ route('enemies.battle', $enemy->getUuid()) }}">Атаковать</button>
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
