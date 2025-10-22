<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index', [
            'title' => 'Roles',
            'items' => Role::where('name', '!=', 'SUPER ADMIN')->get(),
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
            $role = Role::WithCount('users')->findOrFail($role->id);
            if ($role->users_count > 0) {
                return to_route('roles.index')->with('error', 'No se puede eliminar el rol porque está asignado a uno o más usuarios.');
            }
            $role->delete();
            return to_route('roles.index')->with('success', 'Rol eliminado exitosamente.');
        } catch (\Exception $e) {
            return to_route('roles.index')->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }

    public function showPermissions(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($permission){
            if(stripos($permission->name, 'setting') !== false){return 'Configuraciones';}
            if(stripos($permission->name, 'role') !== false){return 'Roles';}
            if(stripos($permission->name, 'user') !== false){return 'Usuarios';}
            if(stripos($permission->name, 'space') !== false){return 'Espacios de Estacionamiento';}
            if(stripos($permission->name, 'rate') !== false){return 'Tarifas';}
            if(stripos($permission->name, 'customer') !== false){return 'Clientes';}
            if(stripos($permission->name, 'vehicle') !== false){return 'Vehículos';}
            if(stripos($permission->name, 'ticket') !== false){return 'Tickets';}
            if(stripos($permission->name, 'invoice') !== false){return 'Facturaciones';}
            if(stripos($permission->name, 'analytic') !== false){return 'Análisis y Gráficos';}
            if(stripos($permission->name, 'report') !== false){return 'Reportes';}
        });

        return view('admin.roles.show_permissions', [
            'title' => 'Asignar Permisos al Rol: ' . $role->name,
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function assignPermissions(Request $request, Role $role)
    {
        try {
            $role = Role::findOrFail($role->id);
            $role->permissions()->sync($request->permissions);

            return to_route('roles.index')->with('success', 'Permisos asignados exitosamente.');
        } catch (\Exception $e) {
            return to_route('roles.index')->with('error', 'Error al asignar permisos: ' . $e->getMessage());
        }
    }
}
