@extends('layouts.container')

@section('content')
    <div class="flex-col-8 pad-13">
        <h1 class="color-brand">Все игровые локации</h1>
        <p class="font-lg">Список локаций, которые вы можете встретить в игровом мире</p>
    </div>

    <div class="row g-4">
        @foreach ($locations as $location)
            <div class="col-12 col-md-6 col-lg-4">
                @component('db.locations.components.card', compact('location'))
                @endcomponent
            </div>
        @endforeach
    </div>
@endsection
