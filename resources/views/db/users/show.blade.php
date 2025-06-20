



@extends('layouts.container')

@section('content')
    <div class="row">
        <div class="col">
            <div class="pad-13 flex-col-8">
                <h1>{{ $user->getTitle() }}</h1>
            </div>

            @if (count($user->characters) > 0)
                <div>
                    <div class="pad-13 flex-col-5">
                        <h2>Персонажи профиля</h2>
                        <p>Локации, в которые вы можете попасть</p>
                    </div>

                    <div class="frame">
                        @component('db.characters.components.list', ['characters' => $user->characters])
                        @endcomponent
                    </div>
                </div>
            @endif
        </div>

        <div class="col col-4">
            @component('db.users.frames.stats', compact('user'))
            @endcomponent
        </div>
    </div>
@endsection

