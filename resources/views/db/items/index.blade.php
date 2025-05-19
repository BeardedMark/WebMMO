@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="flex-col-8 pad-13">
                    <h1>Все предметы в игре</h1>
                    <p>Предметы которые можно найти</p>
                </div>

                <div class="frame">
                    @component('db.items.components.list', compact('items'))
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
