<div class="row mt-4">
    {{-- Cliente --}}
    <div class="col-md-6">
        <div class="bg-success text-white px-3 py-2 rounded-top">
            <i class="fas fa-user"></i>&nbsp;<strong>Información del Cliente</strong>
        </div>
        <div class="border border-success rounded-bottom p-3 bg-white">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <b><i class="fas fa-user"></i>&nbsp;Nombre</b>
                    <p class="text-muted">{{ $vehicle->customer->name }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <b><i class="fas fa-id-card"></i>&nbsp;Documento</b>
                    <p class="text-muted">{{ $vehicle->customer->document_type }} -
                        {{ $vehicle->customer->document_number }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <b><i class="fas fa-envelope"></i>&nbsp;Correo</b>
                    <p class="text-muted">{{ $vehicle->customer->email }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <b><i class="fas fa-phone"></i>&nbsp;Teléfono</b>
                    <p class="text-muted">{{ $vehicle->customer->phone }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Vehículo --}}
    <div class="col-md-6">
        <div class="bg-success text-white px-3 py-2 rounded-top">
            <i class="fas fa-car-side"></i>&nbsp;<strong>Información del Vehículo</strong>
        </div>
        <div class="border border-success rounded-bottom p-3 bg-white">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <b><i class="fas fa-car"></i>&nbsp;Placa</b>
                    <p class="text-muted">{{ $vehicle->license_plate }}</p>
                </div>
                <div class="col-md-4 mb-2">
                    <b><i class="fas fa-industry"></i>&nbsp;Marca</b>
                    <p class="text-muted">{{ ucfirst($vehicle->brand) }}</p>
                </div>
                <div class="col-md-4 mb-2">
                    <b><i class="fas fa-car-side"></i>&nbsp;Modelo</b>
                    <p class="text-muted">{{ ucfirst($vehicle->model) }}</p>
                </div>
                <div class="col-md-4 mb-2">
                    <b><i class="fas fa-palette"></i>&nbsp;Color</b>
                    <p class="text-muted">{{ ucfirst($vehicle->color) }}</p>
                </div>
                <div class="col-md-4 mb-2">
                    <b><i class="fas fa-truck"></i>&nbsp;Tipo</b>
                    <p class="text-muted">{{ ucfirst($vehicle->vehicle_type) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
