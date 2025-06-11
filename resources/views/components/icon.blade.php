<img width="{{ $size }}" height="{{ $size }}"

    @isset($class)
        class="{{ $class }}"
    @endisset

    src="https://img.icons8.com/{{ $style ?? 'windows' }}/{{ $size }}/{{ $color }}/{{ $name }}.png"
    alt="{{ $name }}"

    @isset($tooltip)
        data-tooltip="{{ $tooltip }}"
    @endisset/>
