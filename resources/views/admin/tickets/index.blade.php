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
                                                data-space-id="{{ $space->id }}">
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
                                                    data-space-id="{{ $space->id }}">
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
                                                    Precio: {{ $rate->price }}</option>
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
                        <i class="fa-solid fa-tools"></i>&nbsp;Espacio en mantenimiento
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>El espacio se encuentra en mantenimiento.</p>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-car-side"></i>&nbsp;Finalizar Ticket
                    </h5>
                    <button type="button" class="close text-white " data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                        <i class="fa-solid fa-check"></i>&nbsp;Aceptar
                    </button>
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
        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true,
                placeholder: $(this).data('placeholder'),
                width: '80%',
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
                var spaceId = $(this).data('space-id');
                $('#ModalMaintenance').modal('show');
            });

            $('.btn-occupied').on('click', function() {
                var spaceId = $(this).data('space-id');
                $('#ModalOccupied').modal('show');
            });
        });
    </script>
@stop
