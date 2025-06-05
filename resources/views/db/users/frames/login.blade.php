<form class="flex-col-13" method="POST" action="{{ route('users.authorization') }}">
    @csrf

    <input id="login" class="input" type="text" name="login" placeholder="Логин или Email"
        value="{{ old('login') ?? '' }}" required> {{-- autofocus --}}

    <input id="password" class="input" type="password" name="password" placeholder="Пароль" required>

    <div class="flex-row-8 flex ai-center">
        <button class="button" type="submit">Войти</button>
        <p class="color-second font-sm">или <a class="link font-sm" href="{{ route('users.register') }}">Регистрация</a>
            нового профиля</p>
    </div>
</form>
