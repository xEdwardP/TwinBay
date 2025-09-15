@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation (fullscreen mode) --}}
        @if ($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if ($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if (!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if ($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')

    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Exito!',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 3000,
                confirmButtonText: 'Aceptar'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        @endif

        function confirmDelete(event, itemId) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + itemId).submit();
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            const sidebarContent = `
        <div class="p-3">
            <h5 class="mb-2"><i class="fas fa-cogs"></i> Configuración</h5>
            <hr>

            <div class="mb-3">
                <h6 class="text-muted"><i class="fas fa-paint-brush mr-1"></i> Cambiar tema</h6>
                <select id="theme-selector" class="form-control form-control-sm">
                    <option value="default">Por defecto</option>
                    <option value="primary">Azul</option>
                    <option value="success">Verde</option>
                    <option value="danger">Rojo</option>
                    <option value="warning">Amarillo</option>
                    <option value="info">Celeste</option>
                    <option value="secondary">Gris</option>
                </select>
            </div>

            <div class="mb-3">
                <h6 class="text-muted"><i class="fas fa-moon mr-1"></i> Modo oscuro</h6>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="dark-mode">
                    <label class="custom-control-label" for="dark-mode">Activar</label>
                </div>
            </div>

            <hr>
            <h6 class="text-muted"><i class="fas fa-info-circle mr-1"></i> {{ config('app.name') }}</h6>
            <ul class="list-unstyled small text-muted">
                <li><i class="fas fa-user mr-2"></i>{{ Auth::user()->name }}</li>
                <li><i class="fas fa-calendar-day mr-2"></i>{{ date('d/m/Y') }}</li>
                <li><i class="fas fa-clock mr-2"></i>{{ date('H:i') }}</li>
            </ul>
        </div>
    `;

            $('.control-sidebar').html(sidebarContent);

            // Sidebar toggle fix
            $('[data-widget="control-sidebar"]').on('click', function() {
                setTimeout(() => {
                    $('body').toggleClass('control-sidebar-slide-open');
                }, 100);
            });

            // Tema dinámico
            $('#theme-selector').on('change', function() {
                const theme = $(this).val();
                const sidebar = $('.main-sidebar');
                const header = $('.main-header');
                const infoBox = $('.info-box-icon');

                const sidebarThemes =
                    'sidebar-dark-primary sidebar-dark-success sidebar-dark-danger sidebar-dark-warning sidebar-dark-info sidebar-dark-secondary';
                const headerThemes =
                    'navbar-primary navbar-success navbar-danger navbar-warning navbar-info navbar-secondary navbar-white navbar-light';
                const infoThemes = 'bg-info bg-primary bg-success bg-danger bg-warning bg-secondary';

                sidebar.removeClass(sidebarThemes).addClass(`sidebar-dark-${theme} elevation-4`);
                header.removeClass(headerThemes).addClass(theme === 'default' ?
                    'navbar-white navbar-light' : `navbar-${theme} navbar-light`);
                infoBox.removeClass(infoThemes).addClass(theme === 'default' ? 'bg-info' : `bg-${theme}`);

                localStorage.setItem('selected-theme', theme);
            });

            // Modo oscuro
            $('#dark-mode').on('change', function() {
                $('body').toggleClass('dark-mode', this.checked);
                localStorage.setItem('dark-mode', this.checked ? 'true' : 'false');
            });

            // Restaurar preferencias
            const savedTheme = localStorage.getItem('selected-theme') || 'default';
            const darkMode = localStorage.getItem('dark-mode') === 'true';

            $('#theme-selector').val(savedTheme).trigger('change');
            $('#dark-mode').prop('checked', darkMode).trigger('change');
        });
    </script>
@stop
