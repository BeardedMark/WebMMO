<div class="flex-col-13">
    <div class="flex-row-8">
        <div class="flex-row-8 flex grow">
            <a class="button" href="{{ route('pages.main') }}">Главная</a>
            <a class="button" href="{{ route('characters.index') }}">Персонажи</a>
            <a class="button" href="{{ route('locations.index') }}">Локации</a>
            <a class="button" href="{{ route('items.index') }}">Предметы</a>
            <a class="button" href="{{ route('enemies.index') }}">Враги</a>
        </div>

        <div class="flex-row-8 ai-center">
            @if (auth()->check())
                @if (auth()->user()->checkCharacter())
                    <a class="button" href="{{ route('transitions.index') }}">Локация</a>
                    <a class="button" href="{{ route('characters.inventory') }}">Инвентарь</a>
                    <a class="button lock-opacity" href="{{ route('transitions.index') }}">Поединки</a>
                    <a class="button lock-opacity" href="{{ route('transitions.index') }}">Задания</a>
                    <a class="button lock-opacity" href="{{ route('transitions.index') }}">Навыки</a>
                @endif

                <a class="button" href="{{ route('users.main') }}">Профиль</a>
            @else
                <a class="button" href="{{ route('users.login') }}">Войти в профиль</a>
            @endif
        </div>
    </div>

    @if (session('error') || session('warning') || session('success') || $errors->any())
        <div class="frame color-brand">
            @if (session('error'))
                <span>{{ session('error') }}</span>
            @endif

            @if (session('success'))
                <span>{{ session('success') }}</span>
            @endif

            @if (session('warning'))
                <span>{{ session('warning') }}</span>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="flex-col">
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            @endif
        </div>
    @endif
</div>
