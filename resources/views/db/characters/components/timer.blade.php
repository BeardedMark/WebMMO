@if ($character)
    <span
      id="countdown-{{ $character->id }}"
      data-seconds="{{ $character->timeToNextAction() }}"
      style="display: none;"
    >
      {{ gmdate('H:i:s', $character->timeToNextAction()) }}
    </span>
@endif

@push('scripts')
    <script src="{{ asset('js/domains/timer.js') }}"></script>
@endpush
