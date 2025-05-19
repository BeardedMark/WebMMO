{{-- @if ($value || $value > 0) --}}
<p class="flex-row-8 {{ $value || $value > 0 ? '' : 'color-second' }}">
    <small class="font-bold">{{ $name }}</small>
    <span class="separator"></span>
    @isset($link)
        <a class="link" href="{{ $link }}">
        @endisset

        <small class="font-end">{{ $value ?? '–' }}</small>

        @isset($link)
        </a>
    @endisset
</p>
{{-- @endif --}}
