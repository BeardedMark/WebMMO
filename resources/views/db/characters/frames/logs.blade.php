<div id="character-log" class="flex-col"  style="max-height: 200px; overflow-x: hidden;">
    @foreach ($character->getLogs() as $log)
        <p class="flex-row-8 font-sm">
            <span class="flex grow">{{ $log['message'] }}</span>
            <span class="color-second">{{ $log['type'] }}</span>
            <span class="color-second">{{ $log['datetime'] }}</span>
        </p>
    @endforeach
</div>

<script>
    function scrollToBottom() {
        const chat = document.getElementById('character-log');
        chat.scrollTop = chat.scrollHeight;
    }
    scrollToBottom();
</script>
