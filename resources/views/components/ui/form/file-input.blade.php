@props([
    'name',
    'label' => 'Seleccionar archivo',
    'icon' => 'fas fa-image',
    'src' => '',
    'accept' => 'image/*',
    'required' => false,
    'disabled' => false,
    'preview' => true,
    'height' => 'auto',
])

<div class="form-group">
    {{-- Label Text --}}
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

    {{-- Input Icon --}}
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="{{ $icon }}"></i>
            </span>
        </div>

        {{-- Input --}}
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="{{ $name }}" name="{{ $name }}"
                accept="{{ $accept }}" @if ($preview) onchange="previewImage(event)" @endif
                @if ($required) required @endif @if ($disabled) disabled @endif>
            <label class="custom-file-label" for="{{ $name }}">Seleccionar archivo</label>
        </div>
        <x-ui.form.error :field="$name" class="mt-1" />
    </div>
</div>

@if ($preview)
    <div class="mb-2 d-flex justify-content-center" border="1px">
        <img id="imgPreview" src="@if ($src) {{ asset('storage/' . $src) }} @endif"
            alt="Vista previa"
            style="display: none; max-width: 100%; height: @if ($height) {{ $height }} @else auto @endif;" />
    </div>
@endif

<script>
    function previewImage(event) {
        const input = event.target;
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgPreview = document.getElementById('imgPreview');
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
