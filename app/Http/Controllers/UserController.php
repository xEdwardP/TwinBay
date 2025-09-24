<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\NewUserMail;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

use function Pest\Laravel\json;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'title' => 'Usuarios',
            'items' => User::where('name', '!=', 'SUPER ADMIN')->latest()->withTrashed()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'title' => 'Crear Usuario',
            'roles' => Role::where('name', '!=', 'SUPER ADMIN')->get(),
        ]);
    }

    public function store(UserRequest $request)
    {
        try {
            $validated = $request->validated();
            $tempPassword = Str::random(10);

            $user = new User();
            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
            $user->email = $validated['email'];
            $user->password = bcrypt($tempPassword);
            $user->document_type = $validated['document_type'];
            $user->document_number = $validated['document_number'];
            $user->phone = $validated['phone'];
            $user->birthday = $validated['birthday'];
            $user->genre = $validated['genre'];
            $user->address = $validated['address'];
            $user->contact_name = $validated['contact_name'];
            $user->contact_phone = $validated['contact_phone'];
            $user->contact_relationship = $validated['contact_relationship'];
            $user->is_active = $validated['is_active'] ?? true;
            $user->save();

            $user->assignRole($validated['role']);

            Mail::to($user->email)->send(new NewUserMail($user, $tempPassword));

            return redirect()->route('users.index')->with('success', 'Usuario guardado con éxito!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'No se pudo guardar el usuario: ' . $e->getMessage());
        }
    }



    public function show(User $user)
    {
        return view('admin.users.show', [
            'title' => 'Datos del usuario',
            'user' => User::findOrFail($user->id),
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'title' => 'Editar Usuario',
            'item' => User::findOrFail($user->id),
            'roles' => Role::where('name', '!=', 'SUPER ADMIN')->get(),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();
            $user = User::findOrFail($user->id);

            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
            $user->email = $validated['email'];
            $user->document_type = $validated['document_type'];
            $user->document_number = $validated['document_number'];
            $user->phone = $validated['phone'];
            $user->birthday = $validated['birthday'];
            $user->genre = $validated['genre'];
            $user->address = $validated['address'];
            $user->contact_name = $validated['contact_name'];
            $user->contact_phone = $validated['contact_phone'];
            $user->contact_relationship = $validated['contact_relationship'];
            $user->is_active = $validated['is_active'] ?? true;
            $user->save();

            $user->syncRoles($validated['role']);
            return redirect()->route('users.index')->with('success', 'Cambios guardados con éxito!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'No se pudieron guardar los cambios debido a un error: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user = User::findOrFail($user->id);
            if ($user->id === Auth::user()->id) {
                return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario mientras estás autenticado.');
            } else {
                $user->is_active = false;
                $user->save();
                $user->delete();
                return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito!');
            }
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'No se pudo eliminar el usuario debido a un error: ' . $e->getMessage());
        }
    }

    public function restore(string $id)
    {
        try {
            $trashedUser = User::withTrashed()->findOrFail($id);

            $trashedUser->restore();
            $trashedUser->is_active = true;
            $trashedUser->save();

            return redirect()->route('users.index')->with('success', 'Usuario restaurado con éxito!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'No se pudo restaurar el usuario: ' . $e->getMessage());
        }
    }
}
