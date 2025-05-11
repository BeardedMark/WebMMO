{{-- <div class="frame flex-col"> --}}
    <ul>
        @foreach ($character->getLogs() as $log)
            <li>
                {{-- <span>{{ $log['datetime'] }}</span> --}}
                {{-- <span>{{ $log['type'] }}</span> --}}
                <small>{{ $log['message'] }}</small>
            </li>
        @endforeach
    </ul>
{{-- </div> --}}
