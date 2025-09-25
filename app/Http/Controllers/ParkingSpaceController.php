<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingSpaceRequest;
use App\Models\ParkingSpace;
use App\Models\Setting;
use Illuminate\Http\Request;

class ParkingSpaceController extends Controller
{
    public function index()
    {
        return view('admin.spaces.index', [
            'title' => 'Espacios de parqueo',
            'setting' => Setting::first(),
            'spaces' => ParkingSpace::all(),
        ]);
    }

    public function create()
    {
        return view('admin.spaces.create', [
            'title' => 'Crear espacio de parqueo',
        ]);
    }

    public function store(ParkingSpaceRequest $request)
    {
        try {
            ParkingSpace::create($request->validated());
            return to_route('spaces.index')->with('success', 'Espacio de parqueo creado exitosamente!');
        } catch (\Exception $e) {
            return to_route('spaces.index')->with('error', 'No se pudo guardar el espacio de parqueo.' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $space = ParkingSpace::findOrFail($id);
            $space->parking_status = $request->parking_status;
            $space->save();
            return to_route('spaces.index')->with('success', 'Espacio de parqueo actualizado exitosamente!');
        } catch (\Exception $e) {
            return to_route('spaces.index')->with('error', 'Error al actualizar el estado del espacio de estacionamiento ' . $e->getMessage());
        }
    }

    public function destroy(ParkingSpace $parkingSpace)
    {
        //
    }
}
