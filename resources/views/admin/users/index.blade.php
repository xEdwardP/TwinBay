@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[['label' => 'Inicio', 'route' => 'home'], ['label' => 'Listado de usuarios']]" icon="fas fa-fw fa-users" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Usuarios Registrados</h5>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-primary btn-sm rounded-pill">
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
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Correo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->roles->pluck('name')->first() }}</td>
                                    <td class="text-center">{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->email }}</td>
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
                                                <a href="{{ route('users.show', $item) }}"
                                                    class="btn btn-sm btn-info rounded-pill px-4 py-1 mr-2"
                                                    title="Ver Usuario">
                                                    <i class="fa-solid fa-eye"></i>&nbsp;Ver
                                                </a>
                                                <a href="{{ route('users.edit', $item) }}"
                                                    class="btn btn-sm btn-warning rounded-pill px-4 py-1"
                                                    title="Editar Usuario">
                                                    <i class="fa-solid fa-pen-to-square"></i>&nbsp;Editar
                                                </a>
                                                <x-ui.button.delete-button :action="route('users.destroy', $item->id)" :item-id="$item->id"
                                                    title="Eliminar Usuario" label="Eliminar" />
                                            @else
                                                <x-ui.button.restore-button :action="route('users.restore', $item->id)" :item-id="$item->id"
                                                    title="Restaurar usuario" label="Restaurar" />
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
