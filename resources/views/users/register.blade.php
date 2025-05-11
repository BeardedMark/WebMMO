@extends('layouts.hug')

@section('content')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="frame flex-col-13">
                    <h1 class="color-brand">Регистрация</h1>
                    <p>Для работы функционала сайта требуется что бы у вас был профиль на сайте</p>

                    @component('users.frames.register')
                    @endcomponent
                </div>
            </div>
        </div>
    </section>
@endsection
