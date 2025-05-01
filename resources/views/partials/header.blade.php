<div class="flex-col-13">
    <div class="flex-row-8">
        <div class="flex-row-8 flex grow">
            <a class="button" href="{{ route('pages.main') }}">Главная</a>
            <a class="button" href="{{ route('characters.index') }}">Персонажи</a>
            <a class="button" href="{{ route('locations.index') }}">Локации</a>
            <a class="button" href="{{ route('items.index') }}">Предметы</a>
        </div>

        <div class="flex-row-8 ai-center">
            @if (auth()->check())
                @if (count(auth()->user()->characters) > 0)
                    @if (auth()->user()->checkCharacter())
                        <a class="button" href="{{ route('transitions.index') }}">Персонаж</a>
                    @else
                        <a class="button brand" href="{{ route('characters.create') }}">Создать персонажа</a>
                    @endif
                @else
                    <a class="button brand" href="{{ route('characters.select') }}">Выбор персонажа</a>
                @endif

                <a class="button" href="{{ route('auth.main') }}">Профиль</a>
            @else
                <a class="button" href="{{ route('auth.main') }}">Войти в профиль</a>
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
