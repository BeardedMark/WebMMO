@extends('layouts.hug')

@section('content')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="frame flex-col-13">
                    <h1 class="color-brand">Авторизация</h1>
                    <p>Для доступа войдите в свой профиль на сайте с помощью логина/почты и пароля</p>

                    @component('users.frames.login')
                    @endcomponent
                </div>
            </div>
        </div>
    </section>
@endsection
