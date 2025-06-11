@extends('layouts.container')

@section('content')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="flex-col-13">
                    <div class="flex-col-8 pad-13">
                        <h1>Запрос на регистрацию</h1>
                        <p>На данном этапе вход игру по запросу через наш Discord сервер</p>
                        <p class="color-second font-sm">Напишите нам на сервере и мы свяжемся с вами в ЛС</p>
                    </div>

                    <iframe src="https://discord.com/widget?id=1379696891687604244&theme=dark" width="100%" height="350"
                        allowtransparency="true" frameborder="0"
                        sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>

                    <div class="flex-col-8 pad-13">
                        <p class="color-second font-sm">Регистрируясь на сайте вы принимаете <a class="link"
                                href="">политику конфидициальности</a> сайта</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
