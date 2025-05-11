@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <div class="flex-col">
            <h1>{{ $user->login }}</h1>

            <div class="flex-row-8">
                <a class="button" href="{{ route('users.edit', $user) }}">Изменить профиль</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST"
                    onsubmit="return confirm('Удалить эту локацию?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button danger">Удалить профиль</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="flex-col-13">
                    <div class="frame flex-col-13">
                        <strong>Подробности о профиле</strong>

                        <div class="flex-col">
                            <span>Почта: {{ $user->email }}</span>
                            <span>Роль: {{ $user->is_admin ? 'Администратор' : 'Пользователь' }}</span>

                            @if ($user->character)
                                <span>Персонаж:
                                    @component('characters.components.link', ['character' => $user->character])
                                    @endcomponent
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="flex-col-13">

                    <div class="frame flex-col-13">
                        <strong>Персонажи профиля</strong>
                        <div class="flex-col">
                            @foreach ($user->characters as $character)
                                <a class="link"
                                    href="{{ route('characters.show', $character) }}">{{ $character->getTitle() }}</a>
                            @endforeach
                        </div>
                    </div>

                    <div class="frame flex-col-13">
                        <strong>Убежища профиля</strong>
                        <div class="flex-col">
                            @foreach ($user->hideouts as $hideout)
                            @component('hideouts.components.line', compact('hideout'))

                            @endcomponent
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
