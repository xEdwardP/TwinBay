@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Listado de usuarios', 'route' => 'users.index'],
        ['label' => 'Edición de usuario'],
    ]" icon="fas fa-fw fa-users" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-clipboard-list"></i>&nbsp;Datos del Usuario</h3>

                    <div class="card-tools">
                        <a href="{{ route('users.index') }}" class="btn btn-sm px-2">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $item) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-3 mb-2">
                                        <div class="form-group">
                                            <label for="role">Rol&nbsp;<sup class="text-danger">*</sup></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user-shield"></i>
                                                    </span>
                                                </div>
                                                <select name="role" id="role" class="form-control" required>
                                                    <option value="">Seleccione una rol</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}"
                                                            {{ old('role', $item->roles->pluck('name')->first()) == $role->name ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <x-ui.form.error field="role" class="mt-1" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3 mb-2">
                                        <x-ui.form.text-input name="first_name" label="Nombre" placeholder="Ej: Juan Carlos"
                                            icon="fas fa-user
                                            " required
                                            maxlength="255" :value="old('first_name', $item->first_name ?? '')" />
                                    </div>

                                    <div class="form-group col-md-3 mb-2">
                                        <x-ui.form.text-input name="last_name" label="Apellidos"
                                            placeholder="Ej: Pérez Gómez"
                                            icon="fas fa-user
                                            " required
                                            maxlength="255" :value="old('last_name', $item->last_name)" />
                                    </div>

                                    <div class="form-group col-md-3 mb-2">
                                        <x-ui.form.text-input name="email" label="Correo electronico"
                                            placeholder="correo@ejemplo.com" icon="fas fa-envelope" required maxlength="255"
                                            :value="old('email', $item->email)" type="email" />
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
                                                        {{ old('document_type', $item->document_type) == 'DNI' ? 'selected' : '' }}>
                                                        DNI</option>
                                                    <option value="Pasaporte"
                                                        {{ old('document_type', $item->document_type) == 'Pasaporte' ? 'selected' : '' }}>
                                                        Pasaporte
                                                    </option>
                                                    <option value="Licencia de conducir"
                                                        {{ old('document_type', $item->document_type) == 'Licencia de conducir' ? 'selected' : '' }}>
                                                        Licencia de conducir</option>
                                                    <option value="Carnet de extranjero"
                                                        {{ old('document_type', $item->document_type) == 'Carnet de extranjero' ? 'selected' : '' }}>
                                                        Carnet de extranjero</option>
                                                </select>
                                            </div>
                                            <x-ui.form.error field="document_type" class="mt-1" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3 mb-2">
                                        <x-ui.form.number-input name="document_number" label="Numero de documento"
                                            placeholder="0102 2000 00123" icon="fas fa-id-card-alt" required maxlength="50"
                                            :value="old('document_number', $item->document_number)" />
                                    </div>

                                    <div class="form-group col-md-2 mb-2">
                                        <x-ui.form.number-input name="phone" label="Teléfono" placeholder="9988 7766"
                                            icon="fas fa-phone" required maxlength="20" :value="old('phone', $item->phone)" />
                                    </div>

                                    <div class="form-group col-md-2 mb-2">
                                        <x-ui.form.date-input name="birthday" label="Fecha de cumpleaños" :value="old('birthday', $item->birthday)"
                                            icon="fas fa-cake-candles" required />
                                    </div>

                                    <div class="form-group col-md-2 mb-2">
                                        <div class="form-group">
                                            <label for="genre">Genero&nbsp;<sup class="text-danger">*</sup></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-venus-mars"></i>
                                                    </span>
                                                </div>
                                                <select name="genre" id="genre" class="form-control" required>
                                                    <option value="">Seleccione una opción</option>
                                                    <option value="Masculino"
                                                        {{ old('genre', $item->genre) == 'Masculino' ? 'selected' : '' }}>
                                                        Masculino</option>
                                                    <option value="Femenino"
                                                        {{ old('genre', $item->genre) == 'Femenino' ? 'selected' : '' }}>
                                                        Femenino
                                                    </option>
                                                    <option value="Otro"
                                                        {{ old('genre', $item->genre) == 'Otro' ? 'selected' : '' }}>
                                                        Otro</option>
                                                </select>
                                            </div>
                                            <x-ui.form.error field="genre" class="mt-1" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12 mb-2">
                                        <x-ui.form.textarea-input name="address" label="Dirección"
                                            placeholder="Santa Rosa de Copan, Honduras" icon="fas fa-map-marker-alt"
                                            :value="old('address', $item->address)" required maxlength="255" rows="2" />
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-3 mb-2">
                                        <x-ui.form.text-input name="contact_name"
                                            label="Nombre del Contacto de Emergencia" placeholder="Ej: María López"
                                            icon="fas fa-person
                                            " required
                                            maxlength="255" :value="old('contact_name', $item->contact_name)" />
                                    </div>
                                    <div class="form-group col-md-3 mb-2">
                                        <x-ui.form.number-input name="contact_phone"
                                            label="Teléfono del Contacto de Emergencia" placeholder="9988 7766"
                                            icon="fas fa-phone" required maxlength="20" :value="old('contact_phone', $item->contact_phone)" />
                                    </div>
                                    <div class="form-group col-md-3 mb-2">
                                        <x-ui.form.text-input name="contact_relationship" label="Relación o parentesco"
                                            placeholder="Ej: Hermana"
                                            icon="fas fa-user-friends
                                            "
                                            required maxlength="255" :value="old('contact_relationship', $item->contact_relationship)" />
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group col-md-3 mb-2 d-flex align-items-center">
                                            <x-ui.form.toggle-switch-input name="is_active" label="¿Activo?"
                                                :checked="$item->is_active ?? false" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row mt-4">
                            <div class="col-md-12">
                                <a href="{{ route('users.edit', $item) }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-ban"></i>&nbsp;Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
