@foreach ($users as $user)
    @component('db.users.components.link', compact('user'))
    @endcomponent
@endforeach
