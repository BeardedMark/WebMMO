<form class="flex-col-13" method="POST" action="{{ route('auth.authorization') }}">
    @csrf

    <input id="login" class="input" type="text" name="login" placeholder="Логин или Email"
        value="{{ old('login') ?? 'admin' }}" required> {{-- autofocus --}}

    <input id="password" class="input" type="password" name="password" placeholder="Пароль" required value="Dev.201095">

    <div class="flex-row-8 flex ai-center">
        <button type="submit" class="button">Войти</button>
        <a href="{{ route('auth.register') }}" class="link">Регистрация</a>
    </div>
</form>
