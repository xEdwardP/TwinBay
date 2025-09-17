@props([
    'name',
    'label' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'autofocus' => false,
    'icon' => 'fas fa-calendar-alt',
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

        <input type="date" name="{{ $name }}" id="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror" value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}" @if ($required) required @endif
            @if ($readonly) readonly @endif @if ($disabled) disabled @endif
            @if ($autofocus) autofocus @endif>
    </div>

    <x-ui.form.error :field="$name" class="mt-1" />
</div>
