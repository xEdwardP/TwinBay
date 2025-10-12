@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Análisis y Gráficos'],
    ]" icon="fas fa-fw fa-chart-line" />
@stop

@section('content')
    <div class="container-fluid">
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

        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line"></i>&nbsp;<strong>Ingresos Mensuales</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="monthlyIncomeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie"></i>&nbsp;<strong>Seguimiento de parqueo</strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="stateSpacesParkingChart"></canvas>
                        </div>
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
        const incomesData = @json(array_values($incomesData));
        const ctx1 = document.getElementById('monthlyIncomeChart').getContext('2d');

        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ingresos mensuales',
                    data: incomesData,
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto ($)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes'
                        }
                    }
                }
            }
        });

        const ctxPie = document.getElementById('stateSpacesParkingChart').getContext('2d');
        
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Espacios Ocupados', 'Espacios Libres', 'Espacios En mantenimiento'],
                datasets: [{
                    label: 'Espacios de parqueo',
                    data: [{{ $occupiedSpaces }}, {{ $availableSpaces }}, {{ $maintenanceSpaces }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(75, 192, 75, 0.7)',
                        'rgba(255, 206, 86, 0.7)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Espacios de parqueo'
                    }
                }
            }
        });
    </script>
@stop
