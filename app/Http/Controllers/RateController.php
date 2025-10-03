<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Models\Rate;
use App\Models\Setting;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index()
    {
        return view('admin.rates.index', [
            'title' => "Tarifas",
            'items' => Rate::latest()->get(),
            'setting' => Setting::first(),
        ]);
    }

    public function create()
    {
        return view('admin.rates.create', [
            'title' => "Crear nueva tarifa",
        ]);
    }

    public function store(RateRequest $request)
    {
        try {
            Rate::create($request->validated());
            return to_route('rates.index')->with('success', 'Tarifa de parqueo creada exitosamente!');
        } catch (\Exception $e) {
            return to_route('rates.index')->with('error', 'No se pudo guardar la tarifa de parqueo.' . $e->getMessage());
        }
    }

    public function edit(Rate $rate)
    {
        return view('admin.rates.edit', [
            'title' => 'Editar tarifa',
            'item' => $rate,
        ]);
    }

    public function update(RateRequest $request, Rate $rate)
    {
        try {
            $rate->update($request->validated());
            return to_route('rates.index')->with('success', '¡La tarifa se ha actualizado exitosamente!');
        } catch (\Exception $e) {
            return to_route('rates.index')->with('error', 'La tarifa no se pudo actualizar: ' . $e->getMessage());
        }
    }

    public function destroy(Rate $rate)
    {
        try {
            $rate->delete();
            return to_route('rates.index')->with('success', 'La tarifa se ha eliminado exitosamente!');
        } catch (\Exception $e) {
            return to_route('rates.index')->with('error', 'La tarifa no se pudo eliminar: ' . $e->getMessage());
        }
    }
}
