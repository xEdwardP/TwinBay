<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index', [
            'title' => 'Roles',
            'items' => Role::all(),
        ]);
    }

    public function store(RoleRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['name'] = strtoupper($validated['name']);

            Role::create($validated);

            return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', 'Error al crear el rol: ' . $e->getMessage());
        }
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', [
            'title' => 'Editar Rol',
            'item' => $role,
        ]);
    }

    public function update(RoleRequest $request, Role $role)
    {
        try {
            $validated = $request->validated();
            $validated['name'] = strtoupper($validated['name']);
            $role->update($validated);

            return to_route('roles.index')->with('success', 'Rol actualizado exitosamente.');
        } catch (\Exception $e) {
            return to_route('roles.index')->with('error', 'Error al actualizar el proveedor: ' . $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return to_route('roles.index')->with('success', 'Rol eliminado exitosamente.');
        } catch (\Exception $e) {
            return to_route('roles.index')->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }
}
