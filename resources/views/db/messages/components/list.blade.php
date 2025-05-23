<div id="messages-list" class="flex-col" style="min-height: 200px; max-height: 150px">
    @foreach ($messages as $message)
        @component('db.messages.components.line', compact('message'))
        @endcomponent
    @endforeach

    <script>
        setInterval(function() {
            fetch('{{ route('messages.index') }}')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('messages-list').outerHTML = html;
                });
        }, 1000);
    </script>
</div>
