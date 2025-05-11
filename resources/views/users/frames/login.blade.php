<form class="flex-col-13" method="POST" action="{{ route('users.authorization') }}">
    @csrf

    <input id="login" class="input" type="text" name="login" placeholder="Логин или Email"
        value="{{ old('login') ?? 'admin' }}" required> {{-- autofocus --}}

    <input id="password" class="input" type="password" name="password" placeholder="Пароль" required value="Dev.201095">

    <div class="flex-row-8 flex jc-end ai-center">
        <a href="{{ route('users.register') }}" class="link">Регистрация</a>
        <button type="submit" class="button">Войти</button>
    </div>
</form>
