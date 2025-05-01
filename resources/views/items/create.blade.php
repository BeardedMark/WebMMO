@extends('layouts.hug')

@section('content')
    <div class="frame">
        <h1>Создать локацию</h1>
        <form method="POST" action="{{ route('locations.store') }}">
            @csrf
            @include('locations.components.form')
            <button type="submit" class="button">Создать</button>
        </form>
    </div>
@endsection
