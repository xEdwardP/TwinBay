@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Listado de clientes', 'route' => 'customers.index'],
        ['label' => 'Edición de cliente'],
    ]" icon="fas fa-fw fa-users" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Datos del Cliente</h5>
                    </div>

                    <div class="card-tools">
                        <a href="{{ route('customers.index') }}" class="btn btn-sm px-2">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customers.update', $item) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-row">
                            <div class="form-group col-md-4 mb-2">
                                <x-ui.form.text-input name="name" label="Nombre" placeholder="Ej: Juan Carlos"
                                    icon="fas fa-user" maxlength="255" :value="old('name', $item->name)" required />
                            </div>

                            <div class="form-group col-md-4 mb-2">
                                <div class="form-group">
                                    <label for="document_type">Tipo de documento&nbsp;<sup
                                            class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-id-card-alt"></i>
                                            </span>
                                        </div>
                                        <select name="document_type" id="document_type" class="form-control" required>
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

                            <div class="form-group col-md-4 mb-2">
                                <x-ui.form.number-input name="document_number" label="Numero de documento"
                                    placeholder="0102 2000 00123" icon="fas fa-id-card-alt" maxlength="50" :value="old('document_number', $item->document_number)"
                                    required />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4 mb-2">
                                <x-ui.form.text-input name="email" label="Correo electronico"
                                    placeholder="correo@ejemplo.com" icon="fas fa-envelope" maxlength="255"
                                    :value="old('email', $item->email)" type="email" />
                            </div>

                            <div class="form-group col-md-3 mb-2">
                                <x-ui.form.number-input name="phone" label="Teléfono" placeholder="9988 7766"
                                    icon="fas fa-phone" maxlength="20" :value="old('phone', $item->phone)" required />
                            </div>

                            <div class="form-group col-md-3 mb-2">
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

                            <div class="col-md-2 mb-2">
                                <div class="form-group col-md-3 mb-2 d-flex align-items-center">
                                    <x-ui.form.toggle-switch-input name="is_active" label="¿Activo?" :checked="$item->is_active ?? false" />
                                </div>
                            </div>
                        </div>

                        <div class="form-row mt-4">
                            <div class="col-md-12">
                                <a href="{{ route('customers.edit', $item->id) }}" class="btn btn-secondary">
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
