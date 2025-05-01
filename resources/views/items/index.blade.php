@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <div class="flex-col">
            <h1>Все предметы</h1>
        </div>

        <div class="row">
            <div class="col">
                <div class="flex-col-13">

                    <div class="frame">
                        @component('items.components.list', ['items' => $allItems])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
