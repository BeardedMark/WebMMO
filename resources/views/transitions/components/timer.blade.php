<span class="flex grow" id="countdown" data-seconds="{{ auth()->user()->character->timeToNextAction() }}">
    {{ gmdate('H:i:s', auth()->user()->character->timeToNextAction()) }}
</span>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var countdownElement = document.getElementById('countdown');

        if (countdownElement) {
            var secondsLeft = parseInt(countdownElement.getAttribute('data-seconds'));
            countdownElement.innerHTML = formatTime(secondsLeft);

            const interval = setInterval(() => {
                secondsLeft--;

                if (secondsLeft < 0) {
                    clearInterval(interval);

                    document.querySelectorAll('.await').forEach(el => {
                        el.classList.remove('await');
                    });

                    return;
                }

                countdownElement.innerHTML = formatTime(secondsLeft);
            }, 1000);
        }

        function formatTime(seconds) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds % 3600) / 60);
            var remainingSeconds = seconds % 60;

            return (hours < 10 ? '0' + hours : hours) + ':' +
                (minutes < 10 ? '0' + minutes : minutes) + ':' +
                (remainingSeconds < 10 ? '0' + remainingSeconds : remainingSeconds);
        }
    });
</script>
