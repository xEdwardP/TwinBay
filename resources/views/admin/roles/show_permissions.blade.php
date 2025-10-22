@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Listado de roles', 'route' => 'roles.index'],
        ['label' => 'Permisos del rol'],
    ]" icon="fas fa-fw fa-user-shield" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Permisos Registrados</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.assign_permissions', $role) }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach ($permissions as $module => $groupedPermissions)
                                <div class="col-md-3 mb-4">
                                    <div class="card shadow-sm border-left-primary h-100">
                                        <div class="card-header py-2 bg-light">
                                            <h6 class="m-0 font-weight-bold">
                                                <i class="fas fa-lock mr-1"></i> {{ ucfirst($module) }}
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($groupedPermissions as $permission)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}" id="perm_{{ $permission->id }}"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save mr-1"></i> Guardar Permisos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    @include('utils.dataTable.dataTableConfig')
@stop
