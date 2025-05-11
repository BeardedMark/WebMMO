<form class="flex-col-13" method="POST" action="{{ route('users.registration') }}">
    @csrf

    <input id="login" class="input" type="text" name="login" placeholder="Логин"
        value="{{ old('login') ?? 'admin' }}" required> {{-- autofocus --}}

    <input id="email" class="input" type="email" name="email" placeholder="Email"
        value="{{ old('email') ?? 'it@dnl.bz' }}" required>

    <input id="password" class="input" type="password" name="password" placeholder="Пароль" required
        value="Dev.201095">

    <input id="password_confirmation" class="input" type="password" name="password_confirmation"
        placeholder="Подтверждение пароля" required value="Dev.201095">

    <div class="flex-row-8 flex jc-end ai-center">
        <a class="link" href="{{ route('users.login') }}">Войти</a>
        <button class="button" type="submit">Зарегестрироваться</button>
    </div>
</form>
