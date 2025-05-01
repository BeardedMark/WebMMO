@extends('layouts.hug')

@section('content')
    <div class="frame">
        <h1>Редактировать локацию: {{ $location->name }}</h1>
        <form method="POST" action="{{ route('locations.update', $location) }}">
            @csrf
            @method('PUT')
            @include('locations.components.form')
            <button type="submit" class="button">Сохранить</button>
        </form>
    </div>
@endsection
