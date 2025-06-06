<!DOCTYPE html>
<html lang="ru">

<head>
    <meta name="robots" content="noindex, nofollow"> {{--  Блокировка роботов  --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карта Локаций</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>

<body class="relative">
    {{-- <audio id="bg-audio" autoplay loop>
        <source src="@yield('sound')" type="audio/mpeg">
    </audio>

    <script>
        const audio = document.getElementById('bg-audio');
        audio.volume = 0.1;
    </script> --}}

    <div class="wallpaper" style="background-image: url('@yield('wallpaper', asset('storage/images/locations/default.png'))')"></div>
    <div class="overlay"></div>


    <script>
        document.addEventListener('mousemove', (e) => {
            const maxShift = 5;

            const x = e.clientX / window.innerWidth - 0.5; // от -0.5 до 0.5
            const y = e.clientY / window.innerHeight - 0.5;

            const wallpaper = document.querySelector('.wallpaper');
            const moveX = x * maxShift; // сила параллакса по X
            const moveY = y * maxShift; // сила параллакса по Y

            wallpaper.style.backgroundPosition = `calc(50% + ${moveX}px) calc(50% + ${moveY}px)`;
        });
    </script>

    @yield('app-content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/script.js"></script>

    @stack('scripts')
</body>

</html>
