<form class="flex-col-13" method="POST" action="{{ route('users.authorization') }}">
    @csrf

    <input id="login" class="input" type="text" name="login" placeholder="Логин или Email"
        value="{{ old('login') ?? 'admin' }}" required> {{-- autofocus --}}

    <input id="password" class="input" type="password" name="password" placeholder="Пароль" required
        value="Dev.201095">

    <div class="flex-row-8 flex ai-center">
        <button class="button" type="submit">Войти</button>
        <p class="color-second font-small">или <a class="link font-small"
                href="{{ route('users.register') }}">Регистрация</a> нового профиля</p>
    </div>
</form>
