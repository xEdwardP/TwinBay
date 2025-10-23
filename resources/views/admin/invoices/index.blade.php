@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[['label' => 'Inicio', 'route' => 'home'], ['label' => 'Listado de facturas']]" icon="fas fa-fw fa-file-invoice-dollar" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="card-title mt-1">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Facturas Registradas</h5>
                    </div>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="dataTable"
                        class="table table-bordered table-striped table-hover table-sm table-responsive-sm table-responsive-md">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Número de Factura</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Documento</th>
                                <th class="text-center">Placa</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Fecha de Emisión</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $invoice->invoice_number }}</td>
                                    <td class="text-center">{{ $invoice->customer->name }}</td>
                                    <td class="text-center">
                                        {{ $invoice->customer->document_type . ' - ' . $invoice->customer->document_number }}
                                    </td>
                                    <td class="text-center">{{ $invoice->vehicle->license_plate }}</td>
                                    <td class="text-center">{{ $setting->currency . ' ' . number_format($invoice->total, 2) }}</td>
                                    <td class="text-center">{{ $invoice->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('invoices.print', $invoice) }}"
                                                class="btn btn-sm btn-warning rounded-pill px-2 py-1" title="Reimprimir Factura">
                                                <i class="fa-solid fa-print"></i>Reimprimir
                                            </a>
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
