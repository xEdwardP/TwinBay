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
                                        {{ ucfirst($space->parking_status) }}
                                    </div>

                                    <div class="ticket-action">
                                        @if ($space->parking_status === 'disponible')
                                            <button class="btn btn-sm btn-outline-success btn-ticket"
                                                data-space-id="{{ $space->id }}">
                                                Generar Ticket
                                            </button>
                                        @elseif ($space->parking_status === 'ocupado')
                                            <button class="btn btn-sm btn-outline-danger btn-occupied"
                                                data-space-id="{{ $space->id }}">
                                                Finalizar Ticket
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-outline-warning btn-maintenance"
                                                data-space-id="{{ $space->id }}">
                                                Revisar
                                            </button>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-ticket-alt"></i>&nbsp;Generar Ticket
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
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
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
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
        $(function() {
            $('.btn-ticket').on('click', function() {
                var spaceId = $(this).data('space-id');
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
