@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="flex-col-8 pad-13">
                    <h1>Все пользователи</h1>
                    <p>Зарагестриованоые аккаунты на сайте</p>
                </div>

                <div class="frame flex-col">
                    @component('db.users.components.list', compact('users'))
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
