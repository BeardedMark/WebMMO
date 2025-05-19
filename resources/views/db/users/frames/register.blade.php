<form class="flex-col-13" method="POST" action="{{ route('users.registration') }}">
    @csrf

    <input id="login" class="input" type="text" name="login" placeholder="Логин"
        value="{{ old('login') ?? '' }}" required>

    <input id="email" class="input" type="email" name="email" placeholder="Email"
        value="{{ old('email') ?? '' }}" required>

    <input id="password" class="input" type="password" name="password" placeholder="Пароль" required>

    <input id="password_confirmation" class="input" type="password" name="password_confirmation"
        placeholder="Подтверждение пароля" required>

    <div class="flex-row-8 flex ai-center">
        <button class="button" type="submit">Подтвердить</button>
        <p class="color-second font-small">или <a class="link font-small" href="{{ route('users.login') }}">Войти</a> в
            существующий профиль</p>
    </div>
</form>
