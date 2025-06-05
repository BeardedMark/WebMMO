<div class="wallpaper" style="background-image: url('@yield('wallpaper', asset('storage/images/locations/default.png'))')"></div>
<div class="overlay"></div>

@push('script')
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
@endpush
