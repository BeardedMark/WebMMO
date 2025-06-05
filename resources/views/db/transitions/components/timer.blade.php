@if ($character)
    <span class="color-brand" id="countdown-{{ $character->id }}" data-seconds="{{ $character->timeToNextAction() }}" style="display: none;">
        {{ gmdate('H:i:s', $character->timeToNextAction()) }}
    </span>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
    var countdownElement = document.getElementById('countdown-{{ $character->id }}');

    if (!countdownElement) return;

    var secondsLeft = parseInt(countdownElement.getAttribute('data-seconds'));

    // Если таймер уже прошёл — сразу разблокировать
    if (secondsLeft <= 0) {
        unlockElements();
        return;
    }

    // Иначе показать и запустить таймер
    countdownElement.style.display = 'inline';
    countdownElement.innerHTML = formatTime(secondsLeft);

    const interval = setInterval(() => {
        secondsLeft--;

        if (secondsLeft <= 0) {
            clearInterval(interval);
            countdownElement.style.display = 'none';
            unlockElements();
            return;
        }

        countdownElement.innerHTML = formatTime(secondsLeft);
    }, 1000);

    function unlockElements() {
        document.querySelectorAll('.await').forEach(el => {
            el.classList.remove('await');
        });

        // Можешь добавить кастомные действия:
        // document.querySelector('#someButton').disabled = false;
        // document.querySelector('#someBlock').classList.add('active');
    }

    function formatTime(seconds) {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;

        return [h, m, s]
            .map(n => (n < 10 ? '0' + n : n))
            .join(':');
    }
});

</script>
