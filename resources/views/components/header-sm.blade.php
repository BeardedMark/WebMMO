<div class="flex-row-8">
    <p class="flex-grow">
        <span @isset($tooltip) data-tooltip="{{ $tooltip }}" @endisset>
            {{ $header }}
        </span>
    </p>

    @isset($note)
        <p class="font-sm">
            <span class="color-brand">{{ $note }}</span>
        </p>
    @endisset
</div>
