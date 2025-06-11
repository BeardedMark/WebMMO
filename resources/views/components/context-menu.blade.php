<div style="display: inline-block; position: relative;">
    <div onclick="toggleContextMenu(this)" style="cursor: pointer;{{ $triggerStyle ?? '' }}"
        class="{{ $triggerClass ?? '' }}">
        {{ $trigger ?? '' }}
    </div>

    <div class="context-menu frame flex-col-8"
        style="display: none; position: absolute; top: 101%; left: 0; {{ $menuStyle ?? 'min-width: 250px; max-width: 400px;' }} z-index:999">
        {{ $slot }}
    </div>
</div>

@once
    @push('scripts')
        <script>
            function toggleContextMenu(trigger) {
                const wrapper = trigger.parentElement;
                const menu = wrapper.querySelector('.context-menu');
                const isVisible = menu.style.display === 'flex';

                document.querySelectorAll('.context-menu').forEach(m => m.style.display = 'none');

                if (!isVisible) {
                    menu.style.display = 'flex';

                    menu.style.top = '101%';
                    menu.style.bottom = 'auto';
                    menu.style.left = '0';
                    menu.style.right = 'auto';

                    const rect = menu.getBoundingClientRect();
                    const padding = 8;

                    if (rect.bottom > window.innerHeight - padding) {
                        menu.style.top = 'auto';
                        menu.style.bottom = '101%';
                    }

                    if (rect.right > window.innerWidth - padding) {
                        menu.style.left = 'auto';
                        menu.style.right = '0';
                    }

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
    @endpush
@endonce
