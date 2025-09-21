@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Listado de roles', 'route' => 'roles.index'],
        ['label' => 'Edición de Rol'],
    ]" icon="fas fa-fw fa-user-shield" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Datos Generales</h5>
                    </div>

                    <div class="card-tools">
                        <a href="{{ route('roles.index') }}" class="btn btn-sm px-2">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>
                </div>
                <div class="card-body" style="display: block;">
                    <form method="POST" action="{{ route('roles.update', $item->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-12 mb-2">
                                <x-ui.form.text-input name="name" label="Nombre del Rol" placeholder="Ej: Administrador"
                                    icon="fas fa-user-shield" autofocus maxlength="255" :value="old('name', $item->name ?? '')" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{ route('roles.edit', $item->id) }}" class="btn btn-secondary"><i
                                            class="fa-solid fa-ban"></i>&nbsp;Cancelar</a>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
