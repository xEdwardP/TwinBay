@props([
    'title' => 'Editar',
    'icon' => 'fa-solid fa-pen-to-square',
    'label' => '',
    'disabled' => false,
])

<a href="{{ $href }}"
    class="btn btn-sm btn-warning rounded-pill px-4 py-1 @if ($disabled) disabled @endif"
    title="{{ $title }}" @if ($disabled) aria-disabled="true" tabindex="-1" @endif>
    <i class="{{ $icon }}"></i>
    @if ($label)
        &nbsp;{{ $label }}
    @endif
</a>
