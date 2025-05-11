<div class="frame flex-col-13">
    <div class="row g-1">
        <div class="col">
            <small class="color-second">{{ $fromContainer->getItemsCount() }} предм</small>
        </div>

        <div class="col-3">
            <small class="color-second">{{ $fromContainer->getTotalItemsWeight() }} кг</small>
        </div>

        <div class="col-3">
            <small class="color-second">{{ $fromContainer->getTotalItemsCount() }}</small>
        </div>
    </div>

    @if (count($fromContainer->getItems()) > 0)
        <div class="flex-col">
            @foreach ($fromContainer->getItems() as $item)
                @component('items.components.move', [
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
