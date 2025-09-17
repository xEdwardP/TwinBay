@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => null,
    'placeholder' => 'Seleccione una opción',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
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

        <select
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror"
            @if ($required) required @endif
            @if ($readonly) readonly @endif
            @if ($disabled) disabled @endif
        >
            <option value="">{{ $placeholder }}</option>

            @foreach ($options as $key => $value)
                <option value="{{ $key }}"
                    @selected(old($name, $selected) == $key)>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>

    <x-ui.form.error :field="$name" class="mt-1" />
</div>
