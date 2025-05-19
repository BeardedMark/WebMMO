

@if (session('error') || session('warning') || session('success') || $errors->any())
<div class="frame color-brand">
    @if (session('error'))
        <span>{{ session('error') }}</span>
    @endif

    @if (session('success'))
        <span>{{ session('success') }}</span>
    @endif

    @if (session('warning'))
        <span>{{ session('warning') }}</span>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="flex-col">
                <span>{{ $error }}</span>
            </div>
        @endforeach
    @endif
</div>
@endif
