<div class="frame">
    @if (count($fromContainer->getItemsModels()) > 0)
        {{-- <div class="flex-row wrap"> --}}
        <div class="grid">
            @foreach ($fromContainer->getItemsModels() as $item)
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
    @endif
</div>
