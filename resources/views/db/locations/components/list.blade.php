@foreach ($locations as $location)
    @component('db.locations.components.line', compact('location'))
    @endcomponent
@endforeach
