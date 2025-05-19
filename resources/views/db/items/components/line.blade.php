{{-- <p class="flex-row-8">
    <a class="link" href="{{ route('items.show', $item) }}">
        <img width="21" src="{{ $item->getImageUrl() }}" alt="">
        {{ $item->getTitle() }}
    </a>
    <span class="flex grow"></span>
    <small>{{ $item->getWeight()}} кг</small>
    <small class="color-brand">{{ $item->getDropChance() }} %</small>
</p> --}}

<div class="row g-1">
    <div class="col">
        @component('db.items.components.link', compact('item'))
        @endcomponent
    </div>

    <div class="col-1 text-center">
        <small class="color-second">{{ $item->getMinLevel() ?? "–" }}</small>
    </div>

    <div class="col-1 text-center">
        <small class="color-second">{{ $item->getMaxLevel() ?? "–" }}</small>
    </div>

    <div class="col-1 text-end">
        <small class="color-second">{{ $item->getWeight()}} кг</small>
    </div>

    <div class="col-1 text-end">
        <small class="color-second">{{ $item->getDropChance() }} %</small>
    </div>
</div>
