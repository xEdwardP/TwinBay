@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[['label' => 'Inicio', 'route' => 'home'], ['label' => 'Perfil de usuario']]" icon="fas fa-fw fa-user-circle" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title mt-1">
                                <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Datos del usuario</h5>
                            </div>

                            <div class="card-tools">
                                <a href="{{ route('home') }}" class="btn btn-sm px-2">
                                    <i class="fa-solid fa-arrow-left text-black"></i>&nbsp;<span class="text-black">Volver</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('users.update_profile', $user) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-3 mb-2">
                                                <x-ui.form.text-input name="first_name" label="Nombre"
                                                    placeholder="Ej: Juan Carlos" icon="fas fa-user" required
                                                    maxlength="255" :value="old('first_name', $user->first_name ?? '')" />
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <x-ui.form.text-input name="last_name" label="Apellidos"
                                                    placeholder="Ej: Pérez Gómez" icon="fas fa-user" required
                                                    maxlength="255" :value="old('last_name', $user->last_name)" />
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <x-ui.form.text-input name="email" label="Correo electronico"
                                                    placeholder="correo@ejemplo.com" icon="fas fa-envelope" required
                                                    maxlength="255" :value="old('email', $user->email)" type="email" />
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <x-ui.form.number-input name="phone" label="Teléfono"
                                                    placeholder="9988 7766" icon="fas fa-phone" required maxlength="20"
                                                    :value="old('phone', $user->phone)" />
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="document_type">Tipo de documento&nbsp;<sup
                                                            class="text-danger">*</sup></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-id-card-alt"></i>
                                                            </span>
                                                        </div>
                                                        <select name="document_type" id="document_type" class="form-control"
                                                            required>
                                                            <option value="">Seleccione una opción</option>
                                                            <option value="DNI"
                                                                {{ old('document_type', $user->document_type) == 'DNI' ? 'selected' : '' }}>
                                                                DNI</option>
                                                            <option value="Pasaporte"
                                                                {{ old('document_type', $user->document_type) == 'Pasaporte' ? 'selected' : '' }}>
                                                                Pasaporte
                                                            </option>
                                                            <option value="Licencia de conducir"
                                                                {{ old('document_type', $user->document_type) == 'Licencia de conducir' ? 'selected' : '' }}>
                                                                Licencia de conducir</option>
                                                            <option value="Carnet de extranjero"
                                                                {{ old('document_type', $user->document_type) == 'Carnet de extranjero' ? 'selected' : '' }}>
                                                                Carnet de extranjero</option>
                                                        </select>
                                                    </div>
                                                    <x-ui.form.error field="document_type" class="mt-1" />
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <x-ui.form.number-input name="document_number" label="Numero de documento"
                                                    placeholder="0102 2000 00123" icon="fas fa-id-card-alt" required
                                                    maxlength="50" :value="old('document_number', $user->document_number)" />
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <x-ui.form.date-input name="birthday" label="Fecha de cumpleaños"
                                                    :value="old('birthday', $user->birthday)" icon="fas fa-cake-candles" required />
                                            </div>

                                            <div class="form-group col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label for="genre">Genero&nbsp;<sup
                                                            class="text-danger">*</sup></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-venus-mars"></i>
                                                            </span>
                                                        </div>
                                                        <select name="genre" id="genre" class="form-control" required>
                                                            <option value="">Seleccione una opción</option>
                                                            <option value="Masculino"
                                                                {{ old('genre', $user->genre) == 'Masculino' ? 'selected' : '' }}>
                                                                Masculino</option>
                                                            <option value="Femenino"
                                                                {{ old('genre', $user->genre) == 'Femenino' ? 'selected' : '' }}>
                                                                Femenino
                                                            </option>
                                                            <option value="Otro"
                                                                {{ old('genre', $user->genre) == 'Otro' ? 'selected' : '' }}>
                                                                Otro</option>
                                                        </select>
                                                    </div>
                                                    <x-ui.form.error field="genre" class="mt-1" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6 mb-2">
                                                <x-ui.form.textarea-input name="address" label="Dirección"
                                                    placeholder="Santa Rosa de Copan, Honduras" icon="fas fa-map-marker-alt"
                                                    :value="old('address', $user->address)" required maxlength="255" rows="1" />
                                            </div>

                                            <div class="form-group col-md-6 mb-2">
                                                <label for="logo">
                                                    Foto de perfil
                                                </label>
                                                <div class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-fw fa-image"></i>
                                                        </span>
                                                    </div>
                                                    <input type="file" class="form-control" name="userphoto"
                                                        id="userphoto" accept="image/*" onchange="showImage(event)">
                                                </div>
                                                <x-ui.form.error field="userphoto" class="mt-1" />
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <p class="col-md-12 bg-light border-left border-primary pl-2 py-1">
                                                <i class="fas fa-user-friends text-primary"></i>&nbsp;<span
                                                    class="text-primary font-weight-bold">Datos del contacto de
                                                    emergencia</span>
                                            </p>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3 mb-2">
                                                <x-ui.form.text-input name="contact_name"
                                                    label="Nombre del Contacto de Emergencia"
                                                    placeholder="Ej: María López"
                                                    icon="fas fa-person
                                            "
                                                    required maxlength="255" :value="old('contact_name', $user->contact_name)" />
                                            </div>
                                            <div class="form-group col-md-3 mb-2">
                                                <x-ui.form.number-input name="contact_phone"
                                                    label="Teléfono del Contacto de Emergencia" placeholder="9988 7766"
                                                    icon="fas fa-phone" required maxlength="20" :value="old('contact_phone', $user->contact_phone)" />
                                            </div>
                                            <div class="form-group col-md-3 mb-2">
                                                <x-ui.form.text-input name="contact_relationship"
                                                    label="Relación o parentesco" placeholder="Ej: Hermana"
                                                    icon="fas fa-user-friends
                                            "
                                                    required maxlength="255" :value="old('contact_relationship', $user->contact_relationship)" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mt-4">
                                    <div class="col-md-12">
                                        <a href="" class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-ban"></i>&nbsp;Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <div class="card-title mt-1">
                                <h5><i class="fa-solid fa-key"></i>&nbsp;Cambiar contraseña</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('users.change_password', $user) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-4 mb-2">
                                        <x-ui.form.text-input name="current_password" label="Contraseña actual"
                                            placeholder="Contraseña actual" icon="fas fa-lock" type="password"
                                            maxlength="255" required :value="old('current_password')" />
                                    </div>

                                    <div class="form-group col-md-4 mb-2">
                                        <x-ui.form.text-input name="new_password" label="Contraseña nueva"
                                            placeholder="Contraseña nueva" icon="fas fa-key" type="password"
                                            maxlength="255" required :value="old('new_password')" />
                                    </div>

                                    <div class="form-group col-md-4 mb-2">
                                        <x-ui.form.text-input name="new_password_confirmation"
                                            label="Confirmar contraseña nueva" placeholder="Confirmar contraseña nueva"
                                            icon="fas fa-shield-alt" type="password" maxlength="255" required
                                            :value="old('new_password_confirmation')" />
                                    </div>
                                </div>

                                <div class="form-row mt-4">
                                    <div class="col-md-12">
                                        <a href="" class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-ban"></i>&nbsp;Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="fas fa-fw fa-save"></i>&nbsp;Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <b><i class="fas fa-user"></i>Perfil</b>
                    </h3>
                </div>

                <div class="card-body text-center">
                    <div class="d-flex justify-content-center">
                        <img id="preview1"
                            src="{{ isset($user) && $user->userphoto ? asset('storage/users/' . $user->userphoto) : url('/images/NotUserImage.png') }}"
                            alt="Foto de perfil" class="img-fluid img-circle elevation-2 mb-2" style="max-width: 100px;">
                    </div>

                    <h5 class="profile-username mb-1">{{ $user->name }}</h5>

                    <span class="badge badge-info mb-1">{{ $user->roles->pluck('name')->first() }}</span><br>

                    @if ($user->is_active)
                        <span class="badge badge-success">🟢 Activo</span>
                    @else
                        <span class="badge badge-danger">🔴 Inactivo</span>
                    @endif

                    <hr>
                    <small class="text-muted">
                        <b><i class="far fa-clock"></i> Creado el:</b><br>
                        {{ $user->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const showImage = e => document.getElementById('preview1').src = URL.createObjectURL(e.target.files[0]);
    </script>
@stop
