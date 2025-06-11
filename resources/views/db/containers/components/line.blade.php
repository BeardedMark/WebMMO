<div class="row g-1">
    <div class="col">
    <form class="flex-row" method="POST" action="{{ route('containers.interact', ['uuid' => $container->getUuid()]) }}">
        @csrf
        <div class="flex-grow">
        @component('db.containers.components.link', compact('container'))
        @endcomponent
    </div>
        <button class="button">Взаимодействовать</button>
    </form>
    </div>

</div>
