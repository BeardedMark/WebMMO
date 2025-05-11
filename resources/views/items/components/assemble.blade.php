<form class="row g-1" action="{{ route('items.assemble') }}" method="POST" class="flex items-center gap-2">
    @csrf
    <input type="hidden" name="item_id" value="{{ $item->id }}">
    <input type="hidden" name="from_container_type" value="{{ $fromContainer }}">
    <input type="hidden" name="from_container_id" value="{{ $fromId }}">

    <div class="col">
        @component('items.components.link', ['item' => $item])
        @endcomponent
    </div>

    <div class="col-3">
        <span class="color-second">{{ $item->getWeight() }} кг</span>
    </div>

    <div class="col-3">
        <input class="link" type="number" name="stack" value="{{ $item->getMaxStack() }}" min="1"
        max="{{ $item->getMaxStack() }}" class="w-16 text-center">
    </div>

    <div class="col-auto">
        <button class="icon" type="submit" data-tooltip="Переместить">
            @component('components.icon', ['size' => 21, 'name' => 'merge', 'color' => 'BAC7E3'])
            @endcomponent
        </button>
    </div>
</form>
