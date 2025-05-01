@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <h1>Регистрация</h1>

        <div class="frame">
            @component('auth.components.register')
            @endcomponent
        </div>
    </div>
@endsection
