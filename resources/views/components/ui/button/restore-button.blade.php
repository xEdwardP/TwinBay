@props([
    'disabled' => false,
    'label',
])

<form id="restoreForm{{ $itemId }}" action="{{ $action }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 py-1 d-inline-flex align-items-center"
        title="{{ $title }}" @if ($disabled) disabled @endif
        onclick="confirmRestore(event, '{{ $itemId }}')">
        <i class="fa-solid fa-rotate-left"></i>
        @if ($label)
            {{ $label }}
        @endif
    </button>
</form>
