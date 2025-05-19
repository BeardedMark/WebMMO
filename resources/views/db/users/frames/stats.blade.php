<div class="frame flex-col-13" >
    <div>
        @component('components.stat', ['name' => 'Логин', 'value' => $user->getTitle()])
        @endcomponent
        @component('components.stat', ['name' => 'Почта', 'value' => $user->getEmail()])
        @endcomponent
        @component('components.stat', ['name' => 'Роль', 'value' => $user->getRoleTitle()])
        @endcomponent
    </div>

    <div>
        @component('components.stat', ['name' => 'Персонажей', 'value' => count($user->characters)])
        @endcomponent
        @component('components.stat', ['name' => 'Убежищь', 'value' => count($user->hideouts)])
        @endcomponent
    </div>

    <div>
        @component('components.datetime', ['entity' => $user])
        @endcomponent
    </div>
</div>
