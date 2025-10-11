@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Listado de vehiculos', 'route' => 'vehicles.index'],
    ]" icon="fas fa-fw fa-car-side" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Vehiculos Registrados</h5>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('home') }}" class="btn btn-sm px-2">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="dataTable"
                        class="table table-bordered table-striped table-hover table-sm table-responsive-sm table-responsive-md">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Propietario</th>
                                <th class="text-center">Placa</th>
                                <th class="text-center">Marca</th>
                                <th class="text-center">Modelo</th>
                                <th class="text-center">Color</th>
                                <th class="text-center">Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->customer->name }}</td>
                                    <td class="text-center">{{ $item->license_plate }}</td>
                                    <td class="text-center">{{ ucfirst($item->brand) }}</td>
                                    <td class="text-center">{{ ucfirst($item->model) }}</td>
                                    <td class="text-center">{{ ucfirst($item->color) }}</td>
                                    <td class="text-center">{{ ucfirst($item->vehicle_type) }}</td>
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
