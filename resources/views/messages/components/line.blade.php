<small class="flex-row-8">
    <span>
        @component('characters.components.link', ['character' => $message->character])
        @endcomponent

        <span>:</span>
    </span>

    <span class="flex grow">{{ $message->message }}</span>
    <span class="color-second">{{ $message->created_at }}</span>
</small>
