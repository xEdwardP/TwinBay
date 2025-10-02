@props([
    'title' => 'Ver',
    'icon' => 'fa-solid fa-eye',
    'label' => '',
    'href' => '#',
    'disabled' => false,
])

<a href="{{ $href }}"
    class="btn btn-sm btn-info rounded-pill px-4 py-1 d-inline-flex align-items-center @if ($disabled) disabled @endif"
    title="{{ $title }}" @if ($disabled) aria-disabled="true" tabindex="-1" @endif>
    <i class="{{ $icon }}"></i>
    @if ($label)
        &nbsp;{{ $label }}
    @endif
</a>
