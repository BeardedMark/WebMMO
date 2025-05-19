@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-21">
                <div class="pad-13 flex-col-13">
                    <h1>{{ $item->getTitle() }}</h1>

                    @isset($item->description)
                        <p>{{ $item->description }}</p>
                    @endisset
                </div>


                @if (count($item->getCraftItems()) > 0)
                    <div id="locations">
                        <div class="pad-13 flex-col-5">
                            <h2>Состоит из предметов</h2>
                            <p>Предметы которые содеражтся в данном предмете</p>
                        </div>

                        <div class="frame">
                            @foreach ($item->getCraftItems() as $curItem)
                                <div class="row g-1">
                                    <div class="col">
                                        @component('db.items.components.link', ['item' => $curItem->item])
                                        @endcomponent
                                    </div>

                                    <div class="col-1 text-end">
                                        <small class="color-second">{{ $curItem->stack }} шт</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (count($item->usedInCrafts()) > 0)
                    <div id="enemies">
                        <div class="pad-13 flex-col-5">
                            <h2>Содержится в предметах</h2>
                            <p>Предметы внутри которых содержится данный предмет</p>
                        </div>

                        <div class="frame">
                            @component('db.items.components.list', ['items' => $item->usedInCrafts()])
                            @endcomponent
                        </div>
                    </div>
                @endif

                @if (count($item->droppedByEnemies()) > 0)
                    <div id="enemies">
                        <div class="pad-13 flex-col-5">
                            <h2>Выпадает из врагов</h2>
                            <p>Может выпасть при убийстве врага</p>
                        </div>

                        <div class="frame">
                            @component('db.enemies.components.list', ['enemies' => $item->droppedByEnemies()])
                            @endcomponent
                        </div>
                    </div>
                @endif

                @if (count($item->getAvailableProperties()) > 0)
                    <div id="enemies">
                        <div class="pad-13 flex-col-5">
                            <h2>Характеристики предмета</h2>
                            <p>Возможные характеристики которые могут быть на предмете</p>
                        </div>

                        <div class="frame">
                            @foreach ($item->getAvailableProperties() as $prop)
                                <div class="row g-1">
                                    <div class="col">
                                        <p>{{ $prop->name }}</p>
                                    </div>

                                    <div class="col-1 text-end">
                                        <small class="color-second">{{ $prop->value }}</small>
                                    </div>
                                    <div class="col-1 text-end">
                                        <small class="color-second">{{ $prop->spread }} %</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (count($item->getAvailableModifiers()) > 0)
                    <div id="enemies">
                        <div class="pad-13 flex-col-5">
                            <h2>Модификаторы предмета</h2>
                            <p>Возможные модификаторы которые могут быть на предмете</p>
                        </div>

                        <div class="frame">
                            @foreach ($item->getAvailableModifiers() as $mod)
                                <div class="row g-1">
                                    <div class="col">
                                        <p>{{ $mod->name }}</p>
                                    </div>

                                    <div class="col-1 text-end">
                                        <small class="color-second">{{ $mod->value }}</small>
                                    </div>
                                    <div class="col-1 text-end">
                                        <small class="color-second">{{ $mod->spread }} %</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (count($item->availableLocations()) > 0)
                    <div id="enemies">
                        <div class="pad-13 flex-col-5">
                            <h2>Встречается на локациях</h2>
                            <p>Может появится на игровых локациях</p>
                        </div>

                        <div class="frame">
                            @component('db.locations.components.list', ['locations' => $item->availableLocations()])
                            @endcomponent
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <div class="col col-4">
            <div class="flex-col-5">
                <div class="frame">
                    <img width="100%" src="{{ $item->getImageUrl() }}" alt="">
                </div>

                @component('db.items.frames.stats', compact('item'))
                @endcomponent
            </div>
        </div>
    </div>
@endsection
