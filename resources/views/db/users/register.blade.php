@extends('layouts.container')

@section('content')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="flex-col-13">
                    <div class="flex-col-8 pad-13">
                        <h1>Регистрация профиля</h1>
                        <p>Введите данные от новой учетной записи на сайте</p>
                    </div>

                    <div class="frame">
                        @component('db.users.frames.register')
                        @endcomponent
                    </div>

                    <div class="flex-col-8 pad-13">
                        <p class="color-second font-sm">После регистрации вы получите письмо на почту о подтверждении
                            регистрации. Это нужно для проверки почты и защиты от роботов</p>

                        <p class="color-second font-sm">Регистрируясь на сайте вы принимаете <a class="link"
                                href="">правила работы сайта</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
