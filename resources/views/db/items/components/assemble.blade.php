<form class="row g-1" action="{{ route('items.assemble', ['code' => $item->getCode()]) }}" method="POST"
    class="flex items-center gap-2">
    @csrf
    {{-- <input type="hidden" name="id" value="{{ $item->id }}"> --}}
    {{-- <input type="hidden" name="from_container_type" value="{{ $fromContainer }}"> --}}
    {{-- <input type="hidden" name="from_container_id" value="{{ $fromId }}"> --}}

    <div class="col">
        @component('db.items.components.link', ['item' => $item])
        @endcomponent
    </div>

    <div class="col-2">
        <span class="color-second">{{ $item->getWeight() }} кг</span>
    </div>

    <div class="col-2">
        <input class="link" type="number" name="stack" min="1" max="1" class="w-16 text-center">
    </div>

    <div class="col-auto">
        <button class="icon link" type="submit" data-tooltip="Создать">
            <small>Создать</small>
            @component('components.icon', ['size' => 21, 'name' => 'merge', 'color' => 'FFFFFF'])
            @endcomponent
        </button>
    </div>
</form>

<div class="row">
    <div class="col">
        <ul>
            @foreach ($item->getCraftItems() as $craftItem)
                <li>
                    @component('db.items.components.link', ['item' => $craftItem->item])
                    @endcomponent
                    <small>x{{ $craftItem->stack }} шт</small>
                </li>
            @endforeach
        </ul>
    </div>
</div>
