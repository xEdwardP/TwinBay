@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header :title="$title" :breadcrumbs="[
        ['label' => 'Inicio', 'route' => 'home'],
        ['label' => 'Listado de usuarios', 'route' => 'users.index'],
        ['label' => 'Datos del usuario'],
    ]" icon="fas fa-fw fa-users" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-id-badge"></i>&nbsp;Información personal</h3>

                    <div class="card-tools">
                        <a href="{{ route('users.index') }}" class="btn btn-sm px-2">
                            <i class="fa-solid fa-arrow-left"></i>&nbsp;Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <b><i class="fas fa-user"></i>&nbsp;Nombre Completo</b>
                            <p class="text-muted">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <b><i class="fas fa-envelope"></i>&nbsp;Correo</b>
                            <p class="text=muted">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <b><i class="fas fa-id-card"></i>&nbsp;Documento</b>
                            <p class="text=muted">{{ $user->document_type . ' - ' . $user->document_number }}</p>
                        </div>
                        <div class="col-md-3">
                            <b><i class="fas fa-phone"></i>&nbsp;Telefono</b>
                            <p>{{ $user->phone }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <b><i class="fas fa-birthday-cake"></i>&nbsp;Fecha de nacimiento:</b>
                            <p class="text-muted">{{ $user->birthday }}</p>
                        </div>

                        <div class="col-md-3 mb-3">
                            <b><i class="fas fa-venus-mars"></i>&nbsp;Genero</b>
                            <p class="text-muted">{{ $user->genre }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <b><i class="fas fa-map-marker-alt"></i>&nbsp;Dirección</b>
                            <p class="text-muted">{{ $user->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-shield"></i>&nbsp;Contacto de emergencia</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <b><i class="fas fa-user"></i>&nbsp;Nombre</b>
                            <p class="text-muted">{{ $user->contact_name }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <b><i class="fas fa-phone"></i>&nbsp;Telefono:</b>
                            <p class="text-muted">{{ $user->contact_phone }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <b><i class="fas fa-users"></i>&nbsp;Parentesco</b>
                            <p class="text-muted">{{ $user->contact_relationship }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <b><i class="fas fa-user"></i>Perfil</b>
                    </h3>
                </div>

                <div class="card-body text-center">
                    @if ($user->userphoto)
                        <img src="{{ asset('storage/' . $user->userphoto) }}" alt="Foto de perfil"
                            class="img-fluid img-circle elevation-2 mb-2" style="max-width: 100px;">
                    @else
                        <img src="{{ url('/images/NotUserImage.png') }}" alt="Foto de perfil"
                            class="img-fluid img-circle elevation-2 mb-2" style="max-width: 100px;">
                    @endif

                    <h5 class="profile-username mb-1">{{ $user->name }}</h5>

                    <span class="badge badge-info mb-1">{{ $user->roles->pluck('name')->first() }}</span><br>

                    @if ($user->is_active)
                        <span class="badge badge-success">🟢 Activo</span>
                    @else
                        <span class="badge badge-danger">🔴 Inactivo</span>
                    @endif

                    <hr>
                    <small class="text-muted">
                        <b><i class="far fa-clock"></i> Creado el:</b><br>
                        {{ $user->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
@stop
