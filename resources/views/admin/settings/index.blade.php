@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Ajustes del sistema', 'route' => 'settings.index'],
    ]" icon="fas fa-fw fa-cog" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title ">
                        <h5><i class="fa-solid fa-clipboard-list"></i>&nbsp;Datos Generales</h5>
                    </div>

                    <div class="card-tools">
                        <a href="{{ route('home') }}" class="btn btn-sm px-2">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.store') }} " method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-8">
                                <div class="form-row">
                                    <div class="form-group col-md-4 mb-1">
                                        <x-ui.form.text-input name="name" label="Nombre del Sistema"
                                            placeholder="Ej: Sistema de Parqueo X" icon="fas fa-fw fa-cog" required
                                            maxlength="255" :value="old('name', $setting->name ?? '')" autofocus />
                                    </div>
                                    <div class="form-group col-md-8 mb-1">
                                        <x-ui.form.textarea-input name="description" label="Descripción" required
                                            placeholder="Ej: Descripción del negocio" icon="fas fa-align-left"
                                            maxlength="255" :value="old('description', $setting->description ?? '')" :rows=1 />
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4 mb-1">
                                        <x-ui.form.text-input name="branch" label="Sucursal" placeholder="Ej: Sucursal X"
                                            icon="fas fa-building" required maxlength="150" :value="old('branch', $setting->branch ?? '')" />
                                    </div>

                                    <div class="form-group col-md-4 mb-1">
                                        <x-ui.form.text-input name="phone1" label="Teléfono 1" placeholder="Ej: 99887766"
                                            icon="fas fa-phone" maxlength="30" :value="old('phone1', $setting->phone1 ?? '')" required />
                                    </div>

                                    <div class="form-group col-md-4 mb-1">
                                        <x-ui.form.text-input name="phone2" label="Teléfono 2" placeholder="Ej: 99887766"
                                            icon="fas fa-phone" maxlength="30" :value="old('phone2', $setting->phone2 ?? '')" />
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-8 mb-1">
                                        <x-ui.form.textarea-input name="address" label="Dirección"
                                            placeholder="Ej: Calle Principal" icon="fas fa-map-marker-alt" required
                                            maxlength="255" :value="old('address', $setting->address ?? '')" :rows=1 />
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <div class="form-group">
                                            <label for="currency">Moneda <sup class="text-danger">*</sup></label>
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-fw fa-money-bill-wave"></i>
                                                    </span>
                                                </div>
                                                <select name="currency" id="currency" class="form-control" required>
                                                    <option value="">Seleccione una moneda...</option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency['symbol'] }}"
                                                            {{ old('currency', $setting->currency ?? '') == $currency['symbol'] ? 'selected' : '' }}>
                                                            {{ $currency['name'] . ' - (' . $currency['symbol'] . ')' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <x-ui.form.error field="currency" class="mt-1" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6 mb-1">
                                        <x-ui.form.text-input name="email" label="Correo electronico"
                                            placeholder="Ej: correo@empresa.com" icon="fas fa-envelope" required
                                            maxlength="255" :value="old('email', $setting->email ?? '')" type="email" />
                                    </div>
                                    <div class="form-group col-md-6 mb-1">
                                        <x-ui.form.text-input name="website" label="Sitio Web"
                                            placeholder="Ej: www.empresa.com" icon="fas fa-globe" maxlength="150"
                                            :value="old('website', $setting->website ?? '')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logo">
                                                Logo Principal
                                                @if (!isset($setting) || !$setting->logo)
                                                    <sup class="text-danger">*</sup>
                                                @endif
                                            </label>
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-fw fa-image"></i>
                                                    </span>
                                                </div>
                                                <input type="file" class="form-control" name="logo" id="logo"
                                                    accept="image/*" onchange="showImage(event)"
                                                    @if (!isset($setting) || !$setting->logo) autofocus @endif>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <img id="preview1"
                                                    src="{{ isset($setting) && $setting->logo ? asset('storage/logos/' . $setting->logo) : '' }}"
                                                    alt="Logo Principal" style="max-width: 100px; margin-top: 10px;">
                                            </div>
                                            <x-ui.form.error field="logo" class="mt-1" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logo_auto">
                                                Logo para auto
                                                @if (!isset($setting) || !$setting->logo_auto)
                                                    <sup class="text-danger">*</sup>
                                                @endif
                                            </label>
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-fw fa-image"></i>
                                                    </span>
                                                </div>
                                                <input type="file" class="form-control" name="logo_auto"
                                                    id="logo_auto" accept="image/*" onchange="showImage2(event)"
                                                    @if (!isset($setting) || !$setting->logo_auto) autofocus @endif>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <img id="preview2"
                                                    src="{{ isset($setting) && $setting->logo_auto ? asset('storage/logos/' . $setting->logo_auto) : '' }}"
                                                    alt="Logo para Auto" style="max-width: 100px; margin-top: 10px;">
                                            </div>
                                            <x-ui.form.error field="logo_auto" class="mt-1" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{ route('settings.index') }}" class="btn btn-secondary"><i
                                            class="fa-solid fa-ban"></i>&nbsp;Cancelar</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        const showImage = e => document.getElementById('preview1').src = URL.createObjectURL(e.target.files[0]);
        const showImage2 = e => document.getElementById('preview2').src = URL.createObjectURL(e.target.files[0]);
    </script>
@stop
