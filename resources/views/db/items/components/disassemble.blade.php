<form class="row g-1" action="{{ route('items.disassemble') }}" method="POST" class="flex items-center gap-2">
    @csrf
    <input type="hidden" name="uuid" value="{{ $item->uuid }}">
    <input type="hidden" name="from_container_type" value="{{ $fromContainer }}">
    <input type="hidden" name="from_container_id" value="{{ $fromId }}">

    <div class="col">
        @component('db.items.components.link', ['item' => $item->model])
        @endcomponent
    </div>

    <div class="col-2">
        <span class="color-second">{{ $item->model->getWeight()* $item->stack }} кг</span>
    </div>

    <div class="col-2">
        <input class="link" type="number" name="stack" value="{{ $item->stack }}" min="1"
        max="{{ $item->stack }}" class="w-16 text-center">
    </div>

    <div class="col-auto">
        <button class="icon link" type="submit" data-tooltip="Разобрать">
            <small>Разобрать</small>
            @component('components.icon', ['size' => 21, 'name' => 'divarication', 'color' => 'BAC7E3'])
            @endcomponent
        </button>
    </div>
</form>

<div class="row">
    <div class="col">
        <ul>
            @foreach ($item->model->getCraftItems() as $craftItem)
                <li>
                    <div class="row">
                        <div class="col">
                            @component('db.items.components.line', ['item' => $craftItem->item])
                            @endcomponent
                        </div>
                        <div class="col-auto">
                            <small>{{ $craftItem->stack }} шт</small>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
