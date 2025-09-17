@props(['name', 'label' => '', 'checked' => false, 'required' => false, 'disabled' => false])

<style>
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #28a745;
    }

    input:checked+.slider:before {
        transform: translateX(24px);
    }
</style>

<div class="form-group">
    <label class="form-label d-block" for="{{ $name }}">
        {{ $label }}
        @if ($required)
            <sup class="text-danger">*</sup>
        @endif
    </label>

    <label class="toggle-switch">
        <input type="hidden" name="{{ $name }}" value="0">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1"
            @if (old($name, $checked)) checked @endif @if ($required) required @endif
            @if ($disabled) disabled @endif>
        <span class="slider"></span>
    </label>

    <x-ui.form.error :field="$name" class="mt-1" />
</div>
