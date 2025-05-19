@foreach ($characters as $character)
    @component('db.characters.components.line', compact('character'))
    @endcomponent
@endforeach
