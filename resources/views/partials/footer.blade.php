<footer class="frame"><div class="row gy-4 align-items-start">
            <div class="col-md">
                <div class="row row-cols-3 row-cols-md-3 g-3">
                    <div class="col d-flex flex-column align-items-md-start align-items-center">
                        <a class="link" href="{{ route('pages.main') }}">Главная</a>
                        <a class="link" href="{{ route('pages.about') }}">О игре</a>
                        <a class="link" href="{{ route('pages.lore') }}">Лор</a>
                        <a class="link" href="{{ route('users.index') }}">Пользователи</a>
                    </div>

                    <div class="col d-flex flex-column align-items-md-start align-items-center">
                        <a class="link" href="{{ route('characters.index') }}">Персонажи</a>
                        <a class="link" href="{{ route('locations.index') }}">Локации</a>
                        <a class="link" href="{{ route('items.index') }}">Предметы</a>
                        <a class="link" href="{{ route('enemies.index') }}">Враги</a>
                    </div>

                    <div class="col d-flex flex-column align-items-md-start align-items-center">
                        <a class="link lock-gray-dark-blur" href="{{ route('users.index') }}">Свойства</a>
                        <a class="link lock-gray-dark-blur" href="{{ route('containers.index') }}">Контейнеры</a>
                        <a class="link lock-gray-dark-blur" href="{{ route('users.index') }}">Конструкции</a>
                        <a class="link lock-gray-dark-blur" href="{{ route('users.index') }}">Убежища</a>
                        <a class="link lock-gray-dark-blur" href="{{ route('users.index') }}">События</a>
                    </div>
                </div>
            </div>

            <div class="col-md-auto d-flex flex-column align-items-md-end align-items-center">
                <div class="img-contain mb-1" style="width: 128px">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="logo">
                </div>

                <p class="color-second font-sm">Remnants of the Future © 2025</p>
                <p class="color-second font-sm">WEB MMO RPG</p>
            </div>
        </div>
</footer>
