@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[['label' => 'Inicio', 'route' => 'home'], ['label' => 'Listado de roles', 'route' => 'roles.index']]" icon="fas fa-fw fa-user-shield" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Roles Registrados</h5>
                    </div>

                    <div class="card-tools">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1"
                            data-toggle="modal" data-target="#ModalCreate" title="Nuevo Rol">
                            <i class="fa-solid fa-circle-plus"></i>&nbsp;Nuevo
                        </button>
                        <div class="modal fade" tabindex="-1" id="ModalCreate" aria-labelledby="" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title"><i class="fa-solid fa-circle-plus"></i>&nbsp;Creación de un
                                            Nuevo Rol</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('roles.store') }}" method="POST">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <x-ui.form.text-input name="name" label="Nombre del Rol"
                                                        placeholder="Ej: Administrador" icon="fas fa-user-shield" autofocus
                                                        maxlength="255" :value="old('name')" required />
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
                </div>
                <div class="card-body table-responsive">
                    <table id="dataTable"
                        class="table table-bordered table-striped table-hover table-sm table-responsive-sm table-responsive-md">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->name }}</td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('roles.edit', $item) }}"
                                                class="btn btn-sm btn-info rounded-pill px-4 py-1" title="Asignar Permisos">
                                                <i class="fa-solid fa-gear"></i>
                                            </a>
                                            <a href="{{ route('roles.edit', $item) }}"
                                                class="btn btn-sm btn-warning rounded-pill px-4 py-1 ml-2"
                                                title="Editar Rol">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <x-ui.button.delete-button :action="route('roles.destroy', $item->id)" :item-id="$item->id"
                                                title="Eliminar Rol" />
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
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                @if (session('modal_id'))
                    $('#ModalEdit{{ session('modal_id') }}').modal('show');
                @else
                    $('#ModalCreate').modal('show');
                @endif
            });
        </script>
    @endif
@stop
