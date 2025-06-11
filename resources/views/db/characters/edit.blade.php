@extends('layouts.container')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="flex-col-8 pad-13">
                    <h1>Редактирование персонажа</h1>
                    <p>Укажите новые данные о персонаже</p>
                </div>

                <form class="frame flex-col-13" method="POST" action="{{ route('characters.update', $character) }}">
                    @csrf
                    @method('PUT')
                    <div class="flex-col-8">
                        <label for="description">Краткое описание персонажа</label>
                        <div class="flex-col-5">
                            <input class="input" type="text" name="description" id="description"
                                value="{{ old('description', $character->description) }}" maxlength="150">
                            <p class="font-sm color-second">Публичный статус, максимум 150 символов</p>
                        </div>
                    </div>

                    <div class="flex-col-8">
                        <label for="content">Подробное описание персонажа</label>
                        <div class="flex-col-5">
                            <textarea class="input" name="content" id="content" rows="8" maxlength="3000">
                                        {{ old('content', $character->content) }}
                                    </textarea>
                            <p class="font-sm color-second">Персональный контент персонажа с поддержкой HTML</p>
                        </div>
                    </div>

                    <div class="flex-col-13">
                        <p>Выберите внешний вид персонажа</p>

                        <div class="flex-row flex wrap">
                            @foreach ($avatars as $image)
                                <label class="radio">
                                    <input type="radio" name="image" value="{{ $image }}"
                                        @checked($character->image === $image)>
                                    <img style="width: 100px" src="{{ asset('storage/images/characters/avatars/' . $image) }}"
                                        alt="{{ $image }}">
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex-row-8 flex ai-center">
                        <button type="submit" class="button">Сохранить изменения</button>
                        <p class="color-second font-sm">или <a class="link font-sm"
                                href="{{ route('characters.show', $character) }}">Отменить</a> изменения</p>
                    </div>
                </form>

                <div class="flex-col-8 pad-13">
                    <p class="color-second font-sm">Для избежания блокировки, ознакомтесь <a class="link"
                            href="">правилами</a> создания персонажа</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            @component('db.characters.frames.card', compact('character'))
            @endcomponent
        </div>
    </div>
@endsection
