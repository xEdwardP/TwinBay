<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Pest\ArchPresets\Custom;

use function Pest\Laravel\json;

class VehicleController extends Controller
{
    public function index(){
        return view('admin.vehicles.index', [
            'title' => 'Vehiculos',
            'items' => Vehicle::with('customer')->latest()->get(),
        ]);
    }

    public function store(VehicleRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['license_plate'] = strtoupper($validated['license_plate']);
            Vehicle::create($validated);
            return redirect()->back()->with('success', 'Automóvil registrado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo registrar el automóvil: ' . $e->getMessage());
        }
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        try {
            $validated = $request->validated();
            $validated['license_plate'] = strtoupper($validated['license_plate']);
            $vehicle->update($validated);
            return redirect()->back()->with('success', '¡El automóvil se ha actualizado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'El automóvil no se pudo actualizar: ' . $e->getMessage());
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();
            return redirect()->back()->with('success', 'El automóvil se ha eliminado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'El automóvil no se pudo eliminar: ' . $e->getMessage());
        }
    }
}
