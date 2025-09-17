@props([
    'src' => null,
    'alt' => 'Imagen actual',
    'class' => 'img-fluid img-thumbnail',
])

@if ($src)
    <div class="mb-2">
        <label class="form-label d-block"><i class="fas fa-image"></i>&nbsp;Imagen actual</label>
        <div class="d-flex justify-content-center">
            <img src="{{ asset('storage/' . $src) }}" alt="{{ $alt }}" width="100%" class="{{ $class }}">
        </div>
    </div>
@endif
