@component('components.context-menu', [
    'menuStyle' => 'min-width: 300px; max-width: 400px;',
])
    @slot('trigger')
        <img src="{{ $item->getModel()->getImageUrl() }}" class="img-fill">
    @endslot


    <div class="flex-row-8">
        @component('db.items.components.link', ['item' => $item->getModel()])
        @endcomponent

        <span class="flex-grow"></span>
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
            <img src="{{ $item->getModel()->getImageUrl() }}" class="img-fill">
        </div>
    </div>

    <div class="flex-col font-sm">
        @foreach ($item->getCraftItems() as $craftItem)
            @component('components.stat', [
                'name' => $craftItem->item->getTitle(),
                'value' =>  'x' . $craftItem->stack,
            ])
            @endcomponent
        @endforeach
    </div>

    <form class="flex-col-5" action="{{ route('items.assemble', ['code' => $item->getCode()]) }}" method="POST">
        @csrf

        <input id="stack-input-{{ $item->getId() }}" class="input text-center font-sm flex-grow" type="hidden"
            name="stack" value="1" min="1" max="1">

        <button class="button" type="submit" data-tooltip="Создать">Создать</button>
    </form>
@endcomponent
