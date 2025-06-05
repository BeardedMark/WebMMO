@extends('db.locations.layouts.location')

@section('mid-content')
    <div class="frame flex-col-13">
        @component('db.transitions.components.map', compact('character'))
        @endcomponent
    </div>
@endsection
