<div id="preloader" class="preloader">
    <div class="spinner"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const preloader = document.getElementById('preloader');
        preloader.classList.add('visible');
    });

    window.addEventListener('load', () => {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.classList.remove('visible');
            setTimeout(() => preloader.classList.add('fade-out'), 300);
            setTimeout(() => preloader.remove(), 1000);
        }
    });
</script>
