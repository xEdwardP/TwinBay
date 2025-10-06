@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[['label' => 'Inicio', 'route' => 'home'], ['label' => 'Tickets']]" icon="fas fa-fw fa-ticket-alt" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fa-solid fa-clipboard-list"></i>&nbsp;Seguimiento del parqueo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($spaces as $space)
                            @php
                                $ticket_active = $tickets_actives->firstWhere('parking_space_id', $space->id);
                            @endphp
                            <div class="col-6 col-md-4 col-lg-2 mb-4">
                                <div
                                    class="ticket-card text-center border-{{ $space->parking_status === 'disponible'
                                        ? 'success'
                                        : ($space->parking_status === 'ocupado'
                                            ? 'danger'
                                            : 'warning') }}">
                                    <div class="ticket-status">
                                        @if ($space->parking_status === 'disponible')
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                        @elseif ($space->parking_status === 'ocupado')
                                            <i class="fa-solid fa-car-side text-danger"></i>
                                        @else
                                            <i class="fa-solid fa-tools text-warning"></i>
                                        @endif
                                    </div>

                                    <div class="ticket-icon">
                                        <i class="fa-solid fa-ticket"></i>
                                    </div>
                                    <div class="ticket-label">
                                        Espacio #{{ $space->parking_number }}
                                    </div>
                                    <div class="text-muted small mb-2">
                                        {{ ucfirst($space->parking_status) }}<br>
                                        {{ $ticket_active ? ucfirst($ticket_active->vehicle->license_plate) : '' }}
                                    </div>

                                    <div class="ticket-action">
                                        @if ($ticket_active)
                                            <button class="btn btn-sm btn-outline-danger btn-occupied"
                                                data-space-id="{{ $space->id }}"
                                                data-ticket-id="{{ $ticket_active->id }}"
                                                data-ticket-number="{{ $ticket_active->ticket_number }}"
                                                data-customer="{{ $ticket_active->customer->name }}"
                                                data-document="{{ $ticket_active->customer->document_type }} -
                                                    {{ $ticket_active->customer->document_number }}"
                                                data-license_plate="{{ $ticket_active->vehicle->license_plate }}"
                                                data-space-number="{{ $space->parking_number }}"
                                                data-in-date="{{ $ticket_active->in_date }}"
                                                data-in-time="{{ $ticket_active->in_time }}">
                                                Finalizar Ticket
                                            </button>
                                        @else
                                            @if ($space->parking_status === 'disponible')
                                                <button class="btn btn-sm btn-outline-success btn-ticket"
                                                    data-space-id="{{ $space->id }}"
                                                    data-space-number="{{ $space->parking_number }}">
                                                    Generar Ticket
                                                </button>
                                            @elseif ($space->parking_status === 'ocupado')
                                                <button class="btn btn-sm btn-outline-danger">
                                                    Ocupado
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline-warning btn-maintenance"
                                                    data-space-id="{{ $space->id }}"
                                                    data-space-number="{{ $space->parking_number }}">
                                                    Revisar
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para generar ticket --}}
    <div class="modal fade" id="ModalTicket" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-ticket-alt"></i>&nbsp;Generar Ticket del Espacio # <span id="space"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tickets.store') }}" method="POST" id="form-ticket">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="parking_space_id" id="parking_space_id" hidden readonly>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="vehicle_id">
                                        Placa del vehículo <sup class="text-danger">*</sup>
                                    </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-car"></i>
                                            </span>
                                        </div>
                                        <select name="vehicle_id" id="vehicle_id" class="select2 form-control vehicle"
                                            data-placeholder="Seleccione una placa...">
                                            <option></option>
                                            @foreach ($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}">
                                                    {{ $vehicle->license_plate }} — {{ $vehicle->customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append ml-2 mt-1">
                                            <a href="{{ route('customers.create') }}"
                                                class="btn btn-sm btn-outline-primary d-inline-block" title="Nuevo Cliente">
                                                <i class="fas fa-user-plus"></i>&nbsp;<span
                                                    class="d-none d-md-inline">Nuevo</span>
                                            </a>
                                        </div>
                                    </div>
                                    <x-ui.form.error field="vehicle_id" class="mt-2 text-danger small" />
                                </div>

                            </div>
                        </div>

                        <div id="vehicle_info"></div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rate_id">Tarifas <sup class="text-danger">*</sup></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <select name="rate_id" id="rate_id" class="select2 form-control" hidden>
                                            @foreach ($rates as $rate)
                                                <option value="{{ $rate->id }}">Tarifa: {{ ucfirst($rate->name) }} -
                                                    Tipo: {{ ucfirst($rate->type) }} - Cantidad: {{ $rate->quantity }} -
                                                    Precio: {{ $rate->cost }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-ui.form.error field="rate_id" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <x-ui.form.textarea-input name="observations" label="Observaciones"
                                    placeholder="Ingrese la observacion" icon="fas fa-comment-alt" maxlength="255" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa-solid fa-ban"></i>&nbsp;Cancelar
                        </button>
                        <button type="submit" class="btn btn-outline-success">
                            <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal para espacio en mantenimiento --}}
    <div class="modal fade" id="ModalMaintenance" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-tools"></i>&nbsp;Espacio #<span id="space_number"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Lo sentimos, este espacio se encuentra en mantenimiento.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning" data-dismiss="modal">
                        <i class="fa-solid fa-check"></i>&nbsp;Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para finalizar ticket --}}
    <div class="modal fade" id="ModalOccupied" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger shadow-sm">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-car-side"></i>&nbsp;Finalizar Ticket
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body py-3 px-4">
                    <div class="text-center mb-3">
                        <h5 class="font-weight-bold text-danger">
                            TICKET <span id="ticket_number"></span>
                        </h5>
                    </div>

                    <div class="mb-3">
                        <p class="bg-light border-left border-danger pl-2 py-1 font-weight-bold">
                            <i class="fas fa-user"></i>&nbsp;Datos del Cliente
                        </p>
                        <div class="pl-3">
                            <p><strong>Señor(a):</strong> <span id="customer"></span></p>
                            <p><strong>Documento:</strong> <span id="document"></span></p>
                            <p><strong>Placa:</strong> <span id="license_plate"></span></p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="bg-light border-left border-danger pl-2 py-1 font-weight-bold">
                            <i class="fas fa-door-open"></i>&nbsp;Datos del Ingreso
                        </p>
                        <div class="pl-3">
                            <p><strong>Espacio Nº:</strong> <span id="spaceNumber"></span></p>
                            <p><strong>Fecha:</strong> <span id="in_date"></span></p>
                            <p><strong>Hora:</strong> <span id="in_time"></span></p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer ">
                    <form action="" method="POST" id="form-cancel-ticket" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ticket_id" id="ticket_id" readonly>

                        <button type="submit" id="btn-cancel-ticket" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>&nbsp;Cancelar Ticket
                        </button>
                    </form>

                    <a href="#" id="btn-print" data-dismiss="modal" data-toggle="modal"
                        data-target="#ModalTicketPdf" type="submit" class="btn btn-outline-warning">
                        <i class="fa fa-print"></i>&nbsp;Imprimir Ticket
                    </a>

                    <a href="#" id="btn-invoice" data-toggle="modal" class="btn btn-outline-success">
                        <i class="fa fa-file-invoice"></i>&nbsp;Facturar
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal para imprimir el ticket --}}
    <div class="modal fade" id="ModalTicketPdf" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="fa fa-print"></i>&nbsp;Impresión de Ticket
                    </h5>
                    <button type="button" class="close text-white " data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdf_iframe_ticket" frameborder="0" style="width: 100%; height: 50vh;"></iframe>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    @include('utils.tickets.ticket')
@stop

@section('js')
    <script>
        var ticketPrinter = null;

        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true,
                placeholder: $(this).data('placeholder'),
                width: '88%',
                dropdownParent: $('#ModalTicket')
            });

            $('.vehicle').on('change', function() {
                var vehicleId = $(this).val();

                if (vehicleId) {
                    $.ajax({
                        url: "{{ url('/admin/tickets/vehicle') }}/" + vehicleId,
                        type: 'GET',
                        success: function(data) {
                            $('#vehicle_info').html(data);
                        },
                        error: function() {
                            $('#vehicle_info').html(
                                '<p>Error al cargar la información del vehículo.</p>');
                        }
                    })
                } else {
                    alert("Debe seleccionar un vehiculo");
                }
            });
        });

        $('#form-ticket').on('submit', function(event) {
            var parking_space_id = $('#parking_space_id').val();
            var vehicle_id = $('#vehicle_id').val();
            var rate_id = $('#rate_id').val();
            if (!parking_space_id || !vehicle_id || !rate_id) {
                event.preventDefault();
                alert("Debe llenar todos los campos");
            }
        });

        $(function() {
            $('.btn-ticket').on('click', function({}) {
                var spaceId = $(this).data('space-id');
                var spaceNumber = $(this).data('space-number');
                $('#space').html(spaceNumber);
                $('#parking_space_id').val(spaceId);
                $('#ModalTicket').modal('show');
            });

            $('.btn-maintenance').on('click', function() {
                var spaceNumber = $(this).data('space-number');
                $('#space_number').html(spaceNumber);
                $('#ModalMaintenance').modal('show');
            });

            $('.btn-occupied').on('click', function() {
                var ticketId = $(this).data('ticket-id');
                var ticket_number = $(this).data('ticket-number');
                var customer = $(this).data('customer');
                var document = $(this).data('document');
                var license_plate = $(this).data('license_plate');
                var spaceNumber = $(this).data('space-number');
                var in_date = $(this).data('in-date');
                var in_time = $(this).data('in-time');

                $('#ticket_id').val(ticketId);
                $('#ticket_number').html(ticket_number);
                $('#customer').html(customer);
                $('#document').html(document);
                $('#license_plate').html(license_plate);
                $('#spaceNumber').html(spaceNumber);
                $('#in_date').html(in_date);
                $('#in_time').html(in_time);

                ticketPrinter = $(this).data('ticket-id');
                $('#ModalOccupied').modal('show');
            });

            $('#btn-print').on('click', function() {
                if (ticketPrinter) {
                    var urlPrint = "{{ url('/admin/tickets') }}" + "/" + ticketPrinter + "/print";
                    $('#pdf_iframe_ticket').attr('src', urlPrint);
                }
            });
        });
    </script>

    @if (session('ticket_id'))
        <script>
            var ticketId = "{{ session('ticket_id') }}";
            var urlPrint = "{{ url('/admin/tickets') }}" + "/" + ticketId + "/print";
            $('#ModalTicketPdf').modal('show');
            $('#pdf_iframe_ticket').attr('src', urlPrint);
        </script>
    @endif

    <script>
        $('#btn-cancel-ticket').on('click', function() {
            event.preventDefault();
            var ticketId = $('#ticket_id').val();

            if (ticketId) {
                Swal.fire({
                    title: '¿Desea cancelar este ticket?',
                    text: "¡No podrás revertir esto!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, cancelar',
                    cancelButtonText: 'No, mantener'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('#form-cancel-ticket');
                        var url = "{{ url('admin/tickets/destroy') }}" + "/" + ticketId;
                        form.attr('action', url);
                        form.submit();
                    }
                });
            }
        });
    </script>
@stop
