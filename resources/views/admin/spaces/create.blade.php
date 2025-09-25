@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Espacios de parqueo', 'route' => 'spaces.index'],
        ['label' => 'Nuevo espacio de parqueo', 'route' => 'spaces.create'],
    ]" icon="fas fa-fw fa-parking" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-clipboard-list"></i>&nbsp;Datos del Espacio</h3>

                    <div class="card-tools">
                        <a href="{{ route('spaces.index') }}" class="btn btn-sm px-2">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('spaces.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-12 mb-2">
                                <x-ui.form.text-input name="parking_number" label="Número de parqueo"
                                    placeholder="Ej: A1, C2, B10" icon="fas fa-fw fa-parking" required maxlength="255"
                                    :value="old('parking_number')" />
                            </div>

                            <div class="form-group col-md-12 mb-2">
                                <div class="form-group">
                                    <label for="parking_status">Estado del parqueo&nbsp;<sup
                                            class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        </div>
                                        <select name="parking_status" id="parking_status" class="form-control" required>
                                            <option value="">Seleccione una opción</option>
                                            <option value="disponible"
                                                {{ old('parking_status') == 'disponible' ? 'selected' : '' }}>
                                                Disponible</option>
                                            <option value="ocupado"
                                                {{ old('parking_status') == 'ocupado' ? 'selected' : '' }}>
                                                Ocupado
                                            </option>
                                            <option value="en mantenimiento"
                                                {{ old('parking_status') == 'en mantenimiento' ? 'selected' : '' }}>
                                                En mantenimiento</option>
                                        </select>
                                    </div>
                                    <x-ui.form.error field="parking_status" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <div class="form-row mt-4">
                            <div class="col-md-12">
                                <a href="{{ route('spaces.create') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-ban"></i>&nbsp;Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
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
