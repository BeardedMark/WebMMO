<div class="flex-col-13">
    <div class="flex-row-8">
        <div class="flex-row flex grow">

            <div class="flex-row-13">
                <div class="flex-col">
                    <a class="link" href="{{ route('pages.main') }}">Главная</a>
                    <a class="link" href="{{ route('pages.about') }}">О игре</a>
                    <a class="link" href="{{ route('pages.lore') }}">Лор</a>
                    <a class="link" href="{{ route('users.index') }}">Пользователи</a>
                </div>

                <div class="flex-col">
                    <a class="link" href="{{ route('characters.index') }}">Персонажи</a>
                    <a class="link" href="{{ route('locations.index') }}">Локации</a>
                    <a class="link" href="{{ route('items.index') }}">Предметы</a>
                    <a class="link" href="{{ route('enemies.index') }}">Враги</a>
                </div>

                <div class="flex-col">
                    <a class="link lock-gray-dark-blur" href="{{ route('users.index') }}">Свойства</a>
                    <a class="link lock-gray-dark-blur" href="{{ route('containers.index') }}">Контейнеры</a>
                    <a class="link lock-gray-dark-blur" href="{{ route('users.index') }}">Конструкции</a>
                    <a class="link lock-gray-dark-blur" href="{{ route('users.index') }}">Убежища</a>
                    <a class="link lock-gray-dark-blur" href="{{ route('users.index') }}">События</a>
                </div>
            </div>
        </div>

        <div class="flex-col-8 ai-end">
            <div class="img-contain" style="width: 128px">
                <img src="{{ asset('storage/images/logo.png') }}" alt="logo">
            </div>

            <div>
                <p class="color-second font-sm text-end">Remnants of the Future © 2025</p>
                <p class="color-second font-sm text-end">WEB MMO RPG</p>
            </div>
        </div>
    </div>
</div>
