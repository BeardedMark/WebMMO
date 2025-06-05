{{-- @if ($value || $value > 0) --}}
<p class="flex-row-8 {{ $value || $value > 0 ? '' : 'color-second' }}">
    <span class="font-sm">{{ $name }}</span>
    <span class="separator"></span>
    @isset($link)
        <a class="link" href="{{ $link }}">
        @endisset

        <span class="font-sm font-end">{{ $value ?? '–' }}</span>

        @isset($link)
        </a>
    @endisset
</p>
{{-- @endif --}}
