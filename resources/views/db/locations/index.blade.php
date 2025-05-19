@extends('layouts.hug')

@section('content')
<div class="row">
    <div class="col">
        <div class="flex-col-13">
            <div class="flex-col-8 pad-13">
                <h1>Все игровые локации</h1>
                <p>Список локаций, которые вы можете встретить в игровом мире</p>
            </div>

            @component('db.locations.components.grid', compact('locations'))
            @endcomponent
        </div>
    </div>
</div>
@endsection
