@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <div class="flex-col">
            <h1>Все враги</h1>
        </div>

        <div class="row">
            <div class="col">
                <div class="flex-col-13">

                    <div class="frame">
                        @component('enemies.components.list', compact('enemies'))
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
