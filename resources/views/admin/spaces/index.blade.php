@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Espacios de parqueo', 'route' => 'spaces.index'],
    ]" icon="fas fa-fw fa-parking" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Espacios Registrados</h5>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('spaces.create') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                            <i class="fa-solid fa-circle-plus"></i>&nbsp;Nuevo
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($spaces as $space)
                            <div class="col-md-3 mb-4">
                                <div
                                    class="card shadow-sm border-{{ $space->parking_status == 'disponible' ? 'success' : ($space->parking_status == 'ocupado' ? 'danger' : 'warning') }}">
                                    <div class="card-header text-center bg-light">
                                        <h5 class="font-weight-bold mb-0">Espacio #{{ $space->parking_number }}</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <button type="button"
                                            class="btn btn-block 
                                                {{ $space->parking_status == 'disponible' ? 'btn-outline-success' : ($space->parking_status == 'ocupado' ? 'btn-outline-danger' : 'btn-outline-warning') }}"
                                            data-toggle="modal" data-target="#ModalEditState{{ $space->id }}">
                                            <img src="{{ asset('storage/logos/' . $setting->logo_auto) }}" alt="Auto"
                                                class="img-fluid" style="max-height: 200px;">
                                        </button>
                                        <span
                                            class="badge badge-pill mt-3 
                                                {{ $space->parking_status == 'disponible' ? 'badge-success' : ($space->parking_status == 'ocupado' ? 'badge-danger' : 'badge-warning') }}">
                                            {{ ucfirst($space->parking_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" tabindex="-1" id="ModalEditState{{ $space->id }}" aria-labelledby=""
                                aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title"><i class="fa-solid fa-edit"></i>&nbsp;Cambiar
                                                estado del espacio de parqueo {{ $space->parking_number }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('spaces.update', $space->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-row">
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
                                                                <select name="parking_status" id="parking_status"
                                                                    class="form-control" required>
                                                                    <option value="">Seleccione una opción
                                                                    </option>
                                                                    <option value="disponible"
                                                                        {{ old('parking_status', $space->parking_status) == 'disponible' ? 'selected' : '' }}>
                                                                        Disponible</option>
                                                                    <option value="ocupado"
                                                                        {{ old('parking_status', $space->parking_status) == 'ocupado' ? 'selected' : '' }}>
                                                                        Ocupado
                                                                    </option>
                                                                    <option value="en mantenimiento"
                                                                        {{ old('parking_status', $space->parking_status) == 'en mantenimiento' ? 'selected' : '' }}>
                                                                        En mantenimiento</option>
                                                                </select>
                                                            </div>
                                                            <x-ui.form.error field="parking_status" class="mt-1" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                                            class="fa-solid fa-ban"></i>&nbsp;Cancelar</button>
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
