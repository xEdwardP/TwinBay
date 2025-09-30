@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Listado de tarifas', 'route' => 'rates.index'],
        ['label' => 'Nueva tarifa', 'route' => 'rates.create'],
    ]" icon="fas fa-fw fa-dollar-sign" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-clipboard-list"></i>&nbsp;Datos de la tarifa</h3>

                    <div class="card-tools">
                        <a href="{{ route('rates.index') }}" class="btn btn-sm px-2">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('rates.store') }}">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="name">Nombre de la tarifa&nbsp;<sup class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-tag"></i>
                                            </span>
                                        </div>
                                        <select name="name" id="name" class="form-control" required>
                                            <option value="">Seleccione una tarifa</option>
                                            <option value="regular" {{ old('name') == 'regular' ? 'selected' : '' }}>Tarifa
                                                Regular</option>
                                            <option value="nocturna" {{ old('name') == 'nocturna' ? 'selected' : '' }}>
                                                Tarifa
                                                Nocturna</option>
                                            <option value="fin de semana"
                                                {{ old('name') == 'fin_de_semana' ? 'selected' : '' }}>Tarifa
                                                Fin de semana</option>
                                            <option value="feriados" {{ old('name') == 'feriados' ? 'selected' : '' }}>
                                                Tarifa
                                                Feriados</option>
                                        </select>
                                    </div>
                                    <x-ui.form.error field="name" class="mt-1" />
                                </div>
                            </div>

                            <div class="form-group col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="name">Tipo de tarifa&nbsp;<sup class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                        </div>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="">Seleccione una tarifa</option>
                                            <option value="por hora" {{ old('type') == 'por hora' ? 'selected' : '' }}>Por
                                                Hora</option>
                                            <option value="por dia" {{ old('type') == 'por dia' ? 'selected' : '' }}>Por Dia
                                            </option>
                                        </select>
                                    </div>
                                    <x-ui.form.error field="type" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4 mb-3">
                                <x-ui.form.number-input name="cost" label="Costo" icon="fas fa-dollar-sign"
                                    step="0.01" min="0" :value="old('cost')" required />
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <x-ui.form.number-input name="quantity" label="Cantidad" icon="fas fa-layer-group"
                                    min="0" :value="old('quantity')" required />
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <x-ui.form.number-input name="grace_period_minutes" label="Minutos de gracia"
                                    icon="fas fa-hourglass-half" min="0" :value="old('grace_period_minutes')" required />
                            </div>
                        </div>

                        <div class="form-row mt-4">
                            <div class="col-md-12">
                                <a href="{{ route('rates.create') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-ban"></i>&nbsp;Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
