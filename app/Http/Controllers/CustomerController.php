<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Pest\ArchPresets\Custom;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.customers.index', [
            'title' => 'Clientes',
            'items' => Customer::latest()->withTrashed()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.customers.create', [
            'title' => 'Crear nuevo cliente',
        ]);
    }

    public function store(CustomerRequest $request)
    {
        try {
            Customer::create($request->validated());
            return to_route('customers.index')->with('success', 'Cliente creado exitosamente!');
        } catch (\Exception $e) {
            return to_route('customers.index')->with('error', 'No se pudo guardar el cliente' . $e->getMessage());
        }
    }

    public function show(Customer $customer)
    {
        return view('admin.customers.show', [
            'title' => 'Cliente',
            'customer' => Customer::with('vehicles')->findOrFail($customer->id),
        ]);
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', [
            'title' => 'Editar cliente',
            'item' => $customer,
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $customer->update($request->validated());
            return to_route('customers.index')->with('success', '¡La información del cliente se ha actualizado exitosamente!');
        } catch (\Exception $e) {
            return to_route('customers.index')->with('error', 'La información del cliente no se pudo actualizar: ' . $e->getMessage());
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer = Customer::findOrFail($customer->id);
            $customer->is_active = false;
            $customer->save();
            $customer->delete();
            return to_route('customers.index')->with('success', 'El cliente se ha eliminado exitosamente!');
        } catch (\Exception $e) {
            return to_route('customers.index')->with('error', 'El cliente no se pudo eliminar: ' . $e->getMessage());
        }
    }

    public function restore(string $id)
    {
        try {
            $trashedCustomer = Customer::withTrashed()->findOrFail($id);
            $trashedCustomer->restore();
            $trashedCustomer->is_active = true;
            $trashedCustomer->save();
            return redirect()->route('customers.index')->with('success', 'Cliente restaurado con éxito!');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'No se pudo restaurar el cliente: ' . $e->getMessage());
        }
    }
}
