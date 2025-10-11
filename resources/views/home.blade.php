@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header title="Bienvenido, {{ Auth::user()->name }}" :breadcrumbs="[['label' => 'Inicio', 'route' => 'home']]" icon="fas fa-hand text-warning" />
    <hr>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box zoomP">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('roles.index') }}" class="info-box-icon" title="Ver roles registrados">
                                    <img src="{{ url('/images/icons/roles.gif') }}" alt="Roles Icon">
                                </a>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Roles Registrados</span>
                                <span class="info-box-number">{{ $totalRoles }} Roles</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box zoomP">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('users.index') }}" class="info-box-icon" title="Ver usuarios registrados">
                                    <img src="{{ url('/images/icons/users.gif') }}" alt="Users Icon">
                                </a>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Usuarios Registrados</span>
                                <span class="info-box-number">{{ $totalUsers }} Usuarios</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-9 col-12">
                        <div class="info-box zoomP">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('spaces.index') }}" class="info-box-icon"
                                    title="Ver espacios registrados">
                                    <img src="{{ url('/images/icons/spaces.gif') }}" alt="Parking Spaces Icon">
                                </a>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ $totalParkingSpaces }} Espacios registrados</span>
                                <span class="info-box-number">
                                    <span class="text-success me-3">Libres: {{ $totalAvailableParkingSpaces }} |</span>
                                    <span class="text-danger me-3">Ocupados: {{ $totalOccupiedParkingSpaces }} |</span>
                                    <span class="text-warning">Mantenimiento: {{ $totalMaintenanceParkingSpaces }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box zoomP">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('rates.index') }}" class="info-box-icon" title="Ver tarifas registrados">
                                    <img src="{{ url('/images/icons/rates.gif') }}" alt="Rates Icon">
                                </a>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Tarifas Registrados</span>
                                <span class="info-box-number">{{ $totalRates }} Tarifas</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box zoomP">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('customers.index') }}" class="info-box-icon"
                                    title="Ver clientes registrados">
                                    <img src="{{ url('/images/icons/customers.gif') }}" alt="Customers Icon">
                                </a>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Clientes Registrados</span>
                                <span class="info-box-number">{{ $totalCustomers }} Clientes</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box zoomP">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('vehicles.index') }}" class="info-box-icon"
                                    title="Ver vehicles registrados">
                                    <img src="{{ url('/images/icons/vehicles.gif') }}" alt="Vehicles Icon">
                                </a>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Vehiculos Registrados</span>
                                <span class="info-box-number">{{ $totalVehicles }} Vehiculos</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box zoomP">
                            <span class="info-box-icon bg-info">
                                <a href="{{ route('tickets.index') }}" class="info-box-icon"
                                    title="Ver tickets registrados">
                                    <img src="{{ url('/images/icons/tickets.gif') }}" alt="Tickets Icon">
                                </a>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Tickets Registrados</span>
                                <span class="info-box-number">{{ $totalActiveTickets }} Tickets</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="small-box bg-success zoomP">
                            <div class="inner text-white">
                                <h4 class="fw-bold">{{ $setting->currency }} {{ number_format($totalTodayIncomes, 2) }}
                                </h4>
                                <p>Ingresos de hoy</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="small-box bg-success zoomP">
                            <div class="inner text-white">
                                <h4 class="fw-bold">{{ $setting->currency }}
                                    {{ number_format($totalYesterdayIncomes, 2) }}</h4>
                                <p>Ingresos de ayer</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="small-box bg-info zoomP">
                            <div class="inner text-white">
                                <h4 class="fw-bold">{{ $setting->currency }} {{ number_format($totalWeekIncomes, 2) }}
                                </h4>
                                <p>Ingresos: Esta semana</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="small-box bg-info zoomP">
                            <div class="inner text-white">
                                <h4 class="fw-bold">{{ $setting->currency }}
                                    {{ number_format($totalLastWeekIncomes, 2) }}</h4>
                                <p>Ingresos: Semana anterior</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="small-box bg-primary zoomP">
                            <div class="inner text-white">
                                <h4 class="fw-bold">{{ $setting->currency }} {{ number_format($totalMonthIncomes, 2) }}
                                </h4>
                                <p>Ingresos del mes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 col-6">
                        <div class="small-box bg-primary zoomP">
                            <div class="inner text-white">
                                <h4 class="fw-bold">{{ $setting->currency }}
                                    {{ number_format($totalLastMonthIncomes, 2) }}
                                </h4>
                                <p>Ingresos del mes anterior</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-9">
                        <div class="small-box bg-warning zoomP">
                            <div class="inner text-white">
                                <h4 class="fw-bold">{{ $setting->currency }}
                                    {{ number_format($totalIncomes, 2) }}
                                </h4>
                                <p>Ingresos totales</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="card card-outline card-info mb-3 col-md-12 zoomP">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clock"></i>&nbsp;<strong>Hora actual</strong>
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        <h1 id="clock-hour" class="text-primary font-weight-bold mb-0"></h1>
                        <h5 id="clock-date" class="text-muted mb-0"></h5>
                    </div>
                </div>

                <div class="card card-outline card-primary col-md-12 zoomP">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>&nbsp;<strong>Calendario</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar" style="margin-top: -20px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .zoomP {
            transition: transform 0.3s ease;
            border: 1px solid #c0c0c0;
            box-shadow: #c0c0c0 0px 5px 5px 0px;
        }

        .zoomP:hover {
            transform: scale(1.05);
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendar = new VanillaCalendar('#calendar', {
                type: 'default',
                settings: {
                    lang: 'es',
                    visibility: {
                        theme: 'light'
                    }
                },

                locale: {
                    months: [
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],

                    weekday: [
                        'Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'
                    ]
                },

                actions: {
                    clickDay(event, self) {
                        console.log('Fecha seleccionada:', self.selectedDates[0]);
                    }
                }
            });

            calendar.HTMLElement.style.width = '100%';
            calendar.HTMLElement.style.maxWidth = '100%';

            calendar.init();
        });
    </script>

    <script>
        function updateClock() {
            const date = new Date();
            const days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ];

            const weekDay = days[date.getDay()];
            const day = date.getDate();
            const month = months[date.getMonth()];
            const year = date.getFullYear();

            let hour = date.getHours();
            let minute = date.getMinutes();
            let second = date.getSeconds();

            let meridian = hour >= 12 ? 'PM' : 'AM';
            hour = hour % 12;
            hour = hour ? hour : 12;

            minute = minute < 10 ? '0' + minute : minute;
            second = second < 10 ? '0' + second : second;

            document.getElementById('clock-date').innerHTML = `${weekDay}, ${day} de ${month} de ${year}`;
            document.getElementById('clock-hour').innerHTML = `${hour}:${minute}:${second} ${meridian}`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
@stop
