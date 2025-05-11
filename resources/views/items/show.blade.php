@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            <div class="frame flex-col-13">
                <h1>{{ $item->getTitle() }}</h1>

                @isset($item->description)
                    <p>{{ $item->description }}</p>
                @endisset
            </div>

            <div class="frame flex-col-13">
                <h2>Состоит из предметов</h2>

                <div class="flex-col">
                    @foreach ($item->getCraftItems() as $curItem)
                        <div class="row g-1">
                            <div class="col">
                                @component('items.components.link', ['item' => $curItem->item])
                                @endcomponent
                            </div>

                            <div class="col-1 text-end">
                                <small class="color-second">{{ $curItem->stack }} шт</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="frame flex-col-13">
                <h2>Содержится в предметах</h2>

                @component('items.components.list', ['items' => $item->usedInCrafts()])
                @endcomponent
            </div>

            <div class="frame flex-col-13">
                <h2>Выпадает из врагов</h2>

                @component('enemies.components.list', ['enemies' => $item->droppedByEnemies()])
                @endcomponent
            </div>

            <div class="frame flex-col-13">
                <h2>Встречается на локациях</h2>

                @component('locations.components.list', ['locations' => $item->availableLocations()])
                @endcomponent
            </div>
        </div>

        <div class="col col-4">
            <div class="frame">
                <img width="100%" src="{{ $item->getImageUrl() }}" alt="">
            </div>

            <div class="frame flex-col">
                <a class="link" href="{{ route('items.edit', $item) }}">Изменить предмет</a>
                <form action="{{ route('items.destroy', $item) }}" method="POST"
                    onsubmit="return confirm('Удалить этот предмет?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="link">Удалить предмет</button>
                </form>
            </div>

            @component('items.frames.stats', compact('item'))
            @endcomponent
        </div>
    </div>
@endsection
