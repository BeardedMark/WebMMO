
<div class="relative inline-block text-left">
    <button id="menu-button" class="button">
        Меню
    </button>

    <div id="dropdown" class="d-none absolute">
        <a href="/route1" class="link">Пункт 1</a>
        <a href="/route2" class="link">Пункт 2</a>
        <a href="/route3" class="link">Пункт 3</a>
    </div>
</div>

<script>
    const button = document.getElementById('menu-button');
    const menu = document.getElementById('dropdown');

    button.addEventListener('click', () => {
        menu.classList.toggle('d-none');
    });

    document.addEventListener('click', (e) => {
        if (!button.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('d-none');
        }
    });
</script>
