document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-seconds]").forEach(el => {
        let secondsLeft = parseInt(el.dataset.seconds, 10);
        if (secondsLeft <= 0) {
            unlock(el); return;
        }
        el.style.display = '';
        el.textContent = format(secondsLeft);

        const interval = setInterval(() => {
            secondsLeft--;
            if (secondsLeft <= 0) {
                clearInterval(interval);
                el.style.display = 'none';
                unlock(el);
            } else {
                el.textContent = format(secondsLeft);
            }
        }, 1000);
    });

    function format(sec) {
        const h = Math.floor(sec / 3600);
        const m = Math.floor((sec % 3600) / 60);
        const s = sec % 60;
        let parts = [];
        if (h > 0) parts.push(`${h}ч`);
        if (m > 0) parts.push(`${m}м`);
        if (s > 0) parts.push(`${s}с`);
        return parts.join(' ');
    }

    function unlock(el) {
        document.querySelectorAll(".await").forEach(x => x.classList.remove("await"));
    }
});
