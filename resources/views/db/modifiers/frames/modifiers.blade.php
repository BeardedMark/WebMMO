<div class="flex-col color-second">
    @foreach ($modifiers as $mod)
        @component('components.stat', ['name' => $mod->getName(), 'value' => $mod->getValueTitle()])
        @endcomponent
    @endforeach
</div>
