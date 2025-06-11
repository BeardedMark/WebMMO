@extends('layouts.container')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="flex-col-8 pad-13">
                    <h1>Объекты</h1>
                    <p>Разнообразные предметы и объекты которые можно найти на локациях</p>
                </div>

                <div class="frame">
                        @component('db.containers.components.list', compact('containers'))
                        @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
