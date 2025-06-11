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
    <x-preloader />

    @include('components.wallpaper')

    @yield('app-content')

    <script src="{{ asset('js/scripts.js') }}"></script>

    @stack('scripts')
</body>

</html>
