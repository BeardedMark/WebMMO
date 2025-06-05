@if (count($fromContainer->getItems()) > 0)
    <div class="grid">
        @foreach ($fromContainer->getItems() as $item)
            @component('db.items.components.card', [
                'item' => $item,
                'fromContainer' => $fromContainer->getTable(),
                'fromId' => $fromContainer->id,
                'toContainer' => $toContainer->getTable(),
                'toId' => $toContainer->id,
            ])
            @endcomponent
        @endforeach
    </div>
    @else
            <p class="color-second font-sm">Нет предметов в инвентаре</p>
@endif
