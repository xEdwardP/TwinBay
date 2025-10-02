@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Listado de clientes', 'route' => 'customers.index'],
    ]" icon="fas fa-fw fa-users" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Clientes Registrados</h5>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('customers.create') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                            <i class="fa-solid fa-circle-plus"></i>&nbsp;Nuevo
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="dataTable"
                        class="table table-bordered table-striped table-hover table-sm table-responsive-sm table-responsive-md">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Documento</th>
                                <th class="text-center">Correo electrónico</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Género</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->document_type . ' - ' . $item->document_number }}</td>
                                    <td class="text-center">{{ $item->email ? $item->email : 'N/A' }}</td>
                                    <td class="text-center">{{ $item->phone }}</td>
                                    <td class="text-center">{{ $item->genre }}</td>
                                    <td class="text-center">
                                        @if ($item->is_active == 1)
                                            <span class="badge badge-success rounded-pill px-2">Activo</span>
                                        @else
                                            <span class="badge badge-danger rounded-pill px-2">Inactivo</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            @if (!$item->deleted_at)
                                                <x-ui.button.show-button :href="route('customers.show', $item)" title="Ver Cliente"
                                                    icon="fas fa-car" />

                                                <x-ui.button.edit-button :href="route('customers.edit', $item)" title="Editar cliente" />

                                                <x-ui.button.delete-button :action="route('customers.destroy', $item->id)" :item-id="$item->id"
                                                    title="Eliminar cliente" />
                                            @else
                                                <x-ui.button.restore-button :action="route('customers.restore', $item->id)" :item-id="$item->id"
                                                    title="Restaurar cliente" />
                                            @endif
                                        </div>
                                    </td>
                                </tr>
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
