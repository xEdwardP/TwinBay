@props([
    'name',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'autofocus' => false,
    'maxlength' => 255,
    'icon' => null,
    'type' => 'text',
])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required)
                <sup class="text-danger">*</sup>
            @else
                <sup class="text-danger">(Opcional)</sup>
            @endif
        </label>
    @endif

    <div class="input-group mb-1">
        @if ($icon)
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="{{ $icon }}"></i>
                </span>
            </div>
        @endif

        {{-- value="{{ old($name, $value) }}" --}}

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            maxlength="{{ $maxlength }}"
            class="form-control @error($name) is-invalid @enderror"
            @if ($required) required @endif
            @if ($readonly) readonly @endif
            @if ($autofocus) autofocus @endif
        >
    </div>

    <x-ui.form.error :field="$name" class="mt-1" />
</div>
