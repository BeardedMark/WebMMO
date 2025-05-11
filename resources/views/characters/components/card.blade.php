<div id="character-card" class="frame flex-col-13">
    @component('characters.components.line', compact('character'))
    @endcomponent

    <div class="flex-col-8">
        <p class="health" style="width: {{ $character->getHealthPercent() }}%"></p>
        <p class="experience" style="width: {{ $character->getLevelPercent() }}%"></p>
    </div>
    <p class="flex grow color-brand">
        @component('transitions.components.timer')
        @endcomponent
    </p>

    <script>
        setInterval(function() {
            fetch('{{ route('characters.card') }}')
                .then(response => response.text())
                .then(html => {
                    const el = document.getElementById('character-card');
                    el.outerHTML = html;
                });
        }, 1000);
    </script>
</div>
