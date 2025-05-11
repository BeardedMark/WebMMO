@foreach ($characters as $character)
    @component('characters.components.line', compact('character'))
    @endcomponent
@endforeach
