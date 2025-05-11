@extends('layouts.hug')

@section('content')
<div class="row">
    <div class="col">
        <div class="frame flex-col-13">
            <h1>Все локации</h1>

            @component('locations.components.list', compact('locations'))
            @endcomponent
        </div>
    </div>
</div>
@endsection
