@extends('layouts.container')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-21">

                <div class="pad-13 flex-col-13">
                    <h1>{{ $enemy->getTitle() }}</h1>

                    @isset($enemy->description)
                        <p>{{ $enemy->description }}</p>
                    @endisset
                </div>


                @if (count($enemy->availableItems()) > 0)
                    <div id="locations">
                        <div class="pad-13 flex-col-5">
                            <h2>Содержит предметы</h2>
                            <p>Предметы которые могут выпасть при убийстве врага</p>
                        </div>

                        <div class="frame">
                            @component('db.items.components.list', ['items' => $enemy->availableItems()])
                            @endcomponent
                        </div>
                    </div>
                @endif


                @if (count($enemy->availableItems()) > 0)
                    <div id="locations">
                        <div class="pad-13 flex-col-5">
                            <h2>Встречается на локациях</h2>
                            <p>ЛОкации, где вы можете встретить этого врага</p>
                        </div>

                        <div class="frame">
                            @component('db.locations.components.list', ['locations' => $enemy->availableLocations()])
                            @endcomponent
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col col-4">
            <div class="flex-col-5">
                <div class="frame">
                    <img width="100%" src="{{ $enemy->getImageUrl() }}" alt="">
                </div>

                @component('db.enemies.frames.stats', compact('enemy'))
                @endcomponent
            </div>
        </div>
    </div>
@endsection
