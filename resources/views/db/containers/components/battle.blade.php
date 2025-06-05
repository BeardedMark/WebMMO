
<div style="display: inline-block; position: relative;">

    {{-- Клик-зона отдельно --}}
    <div onclick="toggleContextMenu(this)" style="cursor: pointer; padding: 8px;">
        <img src="{{ $enemy->enemy->getImageUrl() }}" width="48" height="48"  style="border-radius: 100%">
        @if ($enemy->stack > 1)
            <small class=""
                style="position: absolute; left: 0; right: 0; bottom: 0; text-align: end; margin: 1px;">
                x{{ $enemy->stack }}
            </small>
        @endif
    </div>

    {{-- Само меню — теперь не входит в область клика --}}
    <div class="context-menu frame"
        style="display: none; position: absolute; top: 101%; left: 0; min-width: 250px; max-width: 400px; z-index:999">
        <form method="POST" class="flex-col-13">
            @csrf
            @component('db.enemies.components.link', ['enemy' => $enemy->enemy])
            @endcomponent


            {{-- <input type="hidden" name="uuid" value="{{ $enemy->uuid }}"> --}}
        <input type="hidden" name="enemy_id" value="{{ $enemy->enemy->id }}">
            <input class="input w-100" type="number" name="stack" value="{{ $enemy->stack }}" min="1"
                max="{{ $enemy->stack }}">

            <small class="flex-col">
                <button class="link" type="submit" formaction="{{ route('enemies.battle', $enemy->enemy) }}">Атаковать</button>
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
