@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <div class="flex-col">
            <h1>Все локации</h1>
            <div class="flex-row">
                <a class="button" href="{{ route('locations.create') }}">Создать локацию</a>
            </div>
        </div>


        @component('locations.components.grid', ['locations' => $allLocations])
        @endcomponent
    </div>
@endsection
