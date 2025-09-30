@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[['label' => 'Inicio', 'route' => 'home'], ['label' => 'Listado de tarifas', 'route' => 'rates.index']]" icon="fas fa-fw fa-dollar-sign" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Tarifas Registradas</h5>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('rates.create') }}" class="btn btn-outline-primary btn-sm rounded-pill">
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
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Costo</th>
                                <th class="text-center">Minutos de gracia</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ ucfirst($item->name) }}</td>
                                    <td class="text-center">{{ ucfirst($item->type) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">{{ $setting->currency . ' ' . number_format($item->cost, 2) }}
                                    </td>
                                    <td class="text-center">{{ $item->grace_period_minutes }}&nbsp;min</td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <x-ui.button.edit-button :href="route('rates.edit', $item)" title="Editar tarifa" />

                                            <x-ui.button.delete-button :action="route('rates.destroy', $item->id)" :item-id="$item->id"
                                                title="Eliminar tarifa" />
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
