@extends('adminlte::page')

@section('content_header')
    <x-pages.page-header title="Inicio" :breadcrumbs="[['label' => 'Inicio', 'route' => 'home']]" icon="fas fa-fw fa-home" />
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
@stop

@section('js')
@stop
