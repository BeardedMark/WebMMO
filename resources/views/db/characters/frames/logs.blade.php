@foreach ($character->getLogs() as $log)
    <p class="flex-row-8 font-small color-second ">
        <span class="flex grow">{{ $log['message'] }}</span>
        {{-- <span>{{ $log['type'] }}</span> --}}
        <span>{{ $log['datetime'] }}</span>
    </p>
@endforeach
