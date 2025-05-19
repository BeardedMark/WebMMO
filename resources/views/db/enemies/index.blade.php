@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="flex-col-8 pad-13">
                    <h1>Все враги</h1>
                    <p>Враги, которых можно встретить на локациях</p>
                </div>

                <div class="frame">
                        @component('db.enemies.components.list', compact('enemies'))
                        @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
