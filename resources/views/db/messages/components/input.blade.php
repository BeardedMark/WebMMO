<form id="message-form" class="flex-row" action="{{ route('messages.store') }}" method="POST" class="flex items-center gap-2">
    @csrf
    <input class="input flex grow" type="text" name="message" value="" placeholder="Сообщение..." required >

    <button class="button" type="submit" data-tooltip="Переместить">
        @component('components.icon', ['size' => 21, 'name' => 'filled-sent', 'color' => 'BAC7E3'])
        @endcomponent
    </button>
</form>

<script>
    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        form.reset();
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(data => {
        });
    });
</script>
