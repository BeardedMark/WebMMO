<p class="flex-row-8">
    <a class="link" href="{{ route('containers.show', $container->getModel()) }}">
        <img width="21" src="{{ $container->getModel()->getImageUrl() }}" alt="" style="border-radius: 100%">
        {{ $container->getModel()->getTitle()}}
    </a>
</p>
