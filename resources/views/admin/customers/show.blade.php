@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Listado de clientes', 'route' => 'customers.index'],
        ['label' => 'Detalles del cliente'],
    ]" icon="fas fa-fw fa-users" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Datos registrados del cliente</h5>
                    </div>

                    <div class="card-tools">
                        <a href="{{ route('customers.index') }}" class="btn btn-sm px-2">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <b><i class="fas fa-user"></i>&nbsp;Nombre Completo</b>
                            <p class="text-muted">{{ $customer->name }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <b><i class="fas fa-id-card"></i>&nbsp;Documento</b>
                            <p class="text=muted">{{ $customer->document_type . ' - ' . $customer->document_number }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <b><i class="fas fa-envelope"></i>&nbsp;Correo</b>
                            <p class="text=muted">{{ $customer->email }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <b><i class="fas fa-phone"></i>&nbsp;Telefono</b>
                            <p>{{ $customer->phone }}</p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <b><i class="fas fa-venus-mars"></i>&nbsp;Genero</b>
                            <p class="text-muted">{{ $customer->genre }}</p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <b><i class="fas fa-clipboard-check"></i>&nbsp;Estado</b>
                            <p>
                                <span
                                    class="badge badge-pill {{ $customer->is_active ? 'badge-success' : 'badge-danger' }} px-3 py-1">
                                    {{ $customer->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-car-side"></i>&nbsp;Listado de vehiculos</h5>
                    </div>

                    <div class="card-tools">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1"
                            data-toggle="modal" data-target="#ModalCreate" title="Nuevo Vehiculo">
                            <i class="fa-solid fa-circle-plus"></i>&nbsp;Nuevo
                        </button>

                        <div class="modal fade" id="ModalCreate" tabindex="-1" aria-labelledby="" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="exampleModalLabel"><i
                                                class="fa-solid fa-circle-plus"></i>&nbsp;Creación de un Nuevo Vehiculo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('vehicles.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-row">
                                                <input type="text" value="{{ $customer->id }}" name="customer_id" hidden>
                                                <div class="form-group col-md-6 mb-2">
                                                    <x-ui.form.text-input name="license_plate" label="Placa del vehiculo"
                                                        placeholder="ABC-123" icon="fas fa-car" required maxlength="255"
                                                        :value="old('license_plate')" styleInput="text-transform: uppercase;" />
                                                </div>

                                                <div class="form-group col-md-6 mb-2">
                                                    <x-ui.form.text-input name="brand" label="Marca del vehiculo"
                                                        placeholder="Toyota, Honda, Ford, etc" icon="fas fa-industry"
                                                        maxlength="255" :value="old('brand')" />
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <x-ui.form.text-input name="model" label="Modelo del vehiculo"
                                                        placeholder="Corolla, Civic, CRV, etc." icon="fas fa-car-side"
                                                        maxlength="255" :value="old('model')" />
                                                </div>

                                                <div class="form-group col-md-6 mb-2">
                                                    <x-ui.form.text-input name="color" label="Color del vehiculo"
                                                        placeholder="Blanco, Negro, Rojo, etc" icon="fas fa-palette"
                                                        maxlength="255" :value="old('color')" />
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <div class="form-group">
                                                        <label for="vehicle_type">Tipo de vehiculo&nbsp;<sup
                                                                class="text-danger">*</sup></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-truck"></i>
                                                                </span>
                                                            </div>
                                                            <select name="vehicle_type" id="vehicle_type"
                                                                class="form-control" required>
                                                                <option value="carro"
                                                                    {{ old('vehicle_type') == 'carro' ? 'selected' : '' }}>
                                                                    Carro</option>
                                                                <option value="moto"
                                                                    {{ old('vehicle_type') == 'moto' ? 'selected' : '' }}>
                                                                    Moto</option>
                                                                <option value="camion"
                                                                    {{ old('vehicle_type') == 'camion' ? 'selected' : '' }}>
                                                                    Camion
                                                                </option>
                                                                <option value="otro"
                                                                    {{ old('vehicle_type') == 'otro' ? 'selected' : '' }}>
                                                                    Otro</option>
                                                            </select>
                                                        </div>
                                                        <x-ui.form.error field="vehicle_type" class="mt-1" />
                                                    </div>
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
                </div>
                <div class="card-body table-responsive">
                    <table id="dataTable"
                        class="table table-bordered table-striped table-hover table-sm table-responsive-sm table-responsive-md">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Placa</th>
                                <th class="text-center">Marca</th>
                                <th class="text-center">Modelo</th>
                                <th class="text-center">Color</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer->vehicles as $vehicle)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $vehicle->license_plate }}</td>
                                    <td class="text-center">{{ ucfirst($vehicle->brand) }}</td>
                                    <td class="text-center">{{ ucfirst($vehicle->model) }}</td>
                                    <td class="text-center">{{ ucfirst($vehicle->color) }}</td>
                                    <td class="text-center">{{ ucfirst($vehicle->vehicle_type) }}</td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            @if (!$customer->deleted_at)
                                                <button type="button"
                                                    class="btn btn-sm btn-warning rounded-pill px-4 py-1 d-inline-flex align-items-center ml-2 mr-2"
                                                    data-toggle="modal" data-target="#ModalEdit{{ $vehicle->id }}"
                                                    title="Editar vehiculo">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>

                                                <x-ui.button.delete-button :action="route('vehicles.destroy', $vehicle->id)" :item-id="$vehicle->id"
                                                    title="Eliminar vehiculo" />
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="ModalEdit{{ $vehicle->id }}" tabindex="-1"
                                    aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title" id="exampleModalLabel"><i
                                                        class="fa-solid fa-pen-to-square"></i>&nbsp;Edición
                                                    de Vehiculo</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-row">
                                                        <input type="text" value="{{ $customer->id }}"
                                                            name="customer_id" hidden>
                                                        <div class="form-group col-md-6 mb-2">
                                                            <x-ui.form.text-input name="license_plate"
                                                                label="Placa del vehiculo" placeholder="ABC-123"
                                                                icon="fas fa-car" required maxlength="255"
                                                                :value="old(
                                                                    'license_plate',
                                                                    $vehicle->license_plate,
                                                                )"
                                                                styleInput="text-transform: uppercase;" />
                                                        </div>

                                                        <div class="form-group col-md-6 mb-2">
                                                            <x-ui.form.text-input name="brand"
                                                                label="Marca del vehiculo"
                                                                placeholder="Toyota, Honda, Ford, etc"
                                                                icon="fas fa-industry" maxlength="255"
                                                                :value="old('brand', $vehicle->brand)" />
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 mb-2">
                                                            <x-ui.form.text-input name="model"
                                                                label="Modelo del vehiculo"
                                                                placeholder="Corolla, Civic, CRV, etc."
                                                                icon="fas fa-car-side" maxlength="255"
                                                                :value="old('model', $vehicle->model)" />
                                                        </div>

                                                        <div class="form-group col-md-6 mb-2">
                                                            <x-ui.form.text-input name="color"
                                                                label="Color del vehiculo"
                                                                placeholder="Blanco, Negro, Rojo, etc"
                                                                icon="fas fa-palette" maxlength="255"
                                                                :value="old('color', $vehicle->color)" />
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 mb-2">
                                                            <div class="form-group">
                                                                <label for="vehicle_type">Tipo de
                                                                    vehiculo&nbsp;<sup class="text-danger">*</sup></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-truck"></i>
                                                                        </span>
                                                                    </div>
                                                                    <select name="vehicle_type" id="vehicle_type"
                                                                        class="form-control" required>
                                                                        <option value="carro"
                                                                            {{ old('vehicle_type', $vehicle->vehicle_type) == 'carro' ? 'selected' : '' }}>
                                                                            Carro</option>
                                                                        <option value="moto"
                                                                            {{ old('vehicle_type', $vehicle->vehicle_type) == 'moto' ? 'selected' : '' }}>
                                                                            Moto</option>
                                                                        <option value="camion"
                                                                            {{ old('vehicle_type', $vehicle->vehicle_type) == 'camion' ? 'selected' : '' }}>
                                                                            Camion
                                                                        </option>
                                                                        <option value="otro"
                                                                            {{ old('vehicle_type', $vehicle->vehicle_type) == 'otro' ? 'selected' : '' }}>
                                                                            Otro</option>
                                                                    </select>
                                                                </div>
                                                                <x-ui.form.error field="vehicle_type" class="mt-1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal"><i
                                                            class="fa-solid fa-ban"></i>&nbsp;Cancelar</button>
                                                    <button type="submit" class="btn btn-warning"><i
                                                            class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    @include('utils.dataTable.dataTableConfig')
@stop
