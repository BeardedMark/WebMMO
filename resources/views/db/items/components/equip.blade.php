<form class="row g-1" action="{{ route('items.equip') }}" method="POST" class="flex items-center gap-2">
    @csrf
    @isset($item->model)
    <input class="note" type="hidden" name="uuid" value="{{ $item->uuid }}">
    @endisset

    <input type="hidden" name="from_container_type" value="{{ $fromContainer }}">
    <input type="hidden" name="from_container_id" value="{{ $fromId }}">
    <input type="hidden" name="to_container_type" value="{{ $toContainer }}">
    <input type="hidden" name="to_container_id" value="{{ $toId }}">

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
        <button class="icon" type="submit" data-tooltip="Переместить">
            @component('components.icon', ['size' => 21, 'name' => 'up-right-arrow', 'color' => 'BAC7E3'])
            @endcomponent
        </button>
    </div>
</form>

{{-- @dump($item) --}}
