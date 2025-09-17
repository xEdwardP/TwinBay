@props([
    'name',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'autofocus' => false,
    'step' => '1',
    'min' => null,
    'max' => null,
    'icon' => null,
])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required)
                <sup class="text-danger">*</sup>
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

        <input type="number" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}" step="{{ $step }}"
            @if ($min !== null) min="{{ $min }}" @endif
            @if ($max !== null) max="{{ $max }}" @endif
            class="form-control @error($name) is-invalid @enderror" @if ($required) required @endif
            @if ($readonly) readonly @endif @if ($autofocus) autofocus @endif>
    </div>

    <x-ui.form.error :field="$name" class="mt-1" />
</div>
