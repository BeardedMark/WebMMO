@extends('layouts.hug')

@section('content')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="flex-col-13">
                    <div class="flex-col-8 pad-13">
                        <h1>Вход в профиль</h1>
                        <p>Введите данные для входа в свою учетную запись на сайте</p>
                    </div>

                    <div class="frame">
                        @component('db.users.frames.login')
                        @endcomponent
                    </div>

                    <div class="flex-col-8 pad-13">
                        <p class="color-second font-small">Если вы забыли данные для входа то вы всегда можете их <a class="link" href="">восстановить</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
