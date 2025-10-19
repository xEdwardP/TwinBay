@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[['label' => 'Inicio', 'route' => 'home'], ['label' => 'Centro de reportes']]" icon="fas fa-fw fa-file-pdf" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-clipboard-list fa-lg mr-2"></i>
                    <h5 class="mb-0 font-weight-bold">Reporte Semanal</h5>
                </div>
                <div class="card-body table-responsive">
                    <form action="{{ route('reports.weekly_report') }}" method="GET">
                        @csrf
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-4">
                                <label for="start_date">Fecha inicio:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ $startWeek }}" required>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="end_date">Fecha final:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ $endWeek }}" required>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <button type="submit" class="btn btn-outline-primary" title="Generar Reporte Semanal">
                                    <i class="fas fa-file-alt"></i>&nbsp;<span class="d-none d-md-inline">Generar</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-row">
                            <x-ui.form.error field="start_date" class="mt-1" /> <br>
                            <x-ui.form.error field="end_date" class="mt-1" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-clipboard-list fa-lg mr-2"></i>
                    <h5 class="mb-0 font-weight-bold">Reporte Mensual</h5>
                </div>
                <div class="card-body table-responsive">
                    <form action="{{ route('reports.monthly_report') }}" method="GET">
                        @csrf
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-4">
                                <label for="year_filter">Año:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <select name="year_filter" id="year_filter" class="form-control" required>
                                        @for ($i = 2024; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="month_filter">Mes:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <select name="month_filter" id="month_filter" class="form-control" required>
                                        @php
                                            $currentMonth = date('n');
                                            $months = [
                                                1 => 'Enero',
                                                2 => 'Febrero',
                                                3 => 'Marzo',
                                                4 => 'Abril',
                                                5 => 'Mayo',
                                                6 => 'Junio',
                                                7 => 'Julio',
                                                8 => 'Agosto',
                                                9 => 'Septiembre',
                                                10 => 'Octubre',
                                                11 => 'Noviembre',
                                                12 => 'Diciembre',
                                            ];
                                        @endphp

                                        @foreach ($months as $num => $name)
                                            <option value="{{ $num }}"
                                                {{ $num == $currentMonth ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group col-md-4">
                                <button type="submit" class="btn btn-outline-primary" title="Generar Reporte Mensual">
                                    <i class="fas fa-file-alt"></i>&nbsp;<span class="d-none d-md-inline">Generar</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-clipboard-list fa-lg mr-2"></i>
                    <h5 class="mb-0 font-weight-bold">Reporte de Ingresos</h5>
                </div>
                <div class="card-body table-responsive">
                    <form action="{{ route('reports.daily_report') }}" method="GET">
                        @csrf
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-4">
                                <label for="year_filter">Año:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <select name="year_filter" id="year_filter" class="form-control" required>
                                        @for ($i = 2024; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="month_filter">Mes:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <select name="month_filter" id="month_filter" class="form-control" required>
                                        @php
                                            $currentMonth = date('n');
                                            $months = [
                                                1 => 'Enero',
                                                2 => 'Febrero',
                                                3 => 'Marzo',
                                                4 => 'Abril',
                                                5 => 'Mayo',
                                                6 => 'Junio',
                                                7 => 'Julio',
                                                8 => 'Agosto',
                                                9 => 'Septiembre',
                                                10 => 'Octubre',
                                                11 => 'Noviembre',
                                                12 => 'Diciembre',
                                            ];
                                        @endphp

                                        @foreach ($months as $num => $name)
                                            <option value="{{ $num }}"
                                                {{ $num == $currentMonth ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group col-md-4">
                                <button type="submit" class="btn btn-outline-primary"
                                    title="Generar Reporte de Ingresos">
                                    <i class="fas fa-file-alt"></i>&nbsp;<span class="d-none d-md-inline">Generar</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
