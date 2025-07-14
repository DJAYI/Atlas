<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        
        return view('dashboard.pages.users.index', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'institutional_email' => 'required|string|email|max:255|unique:users,institutional_email',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'institutional_email' => $validated['institutional_email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        // Log the creation of the user
        Log::info('User created successfully by user: ' . auth()->user()->email . ' at ' . now());

        return redirect()->route('users')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Update the specified resource in storage.
     */

     public function edit(string $id)
     {
        $user = User::findOrFail($id);
        $roles = Role::all();
        
        return view('dashboard.pages.users.edit', compact('user', 'roles'));
     }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'institutional_email' => 'required|string|email|max:255|unique:users,institutional_email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'institutional_email' => $validated['institutional_email'],
        ]);

        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Sync roles (remove current and assign new)
        $user->syncRoles([$validated['role']]);

        Log::info('User updated successfully by user: ' . auth()->user()->email . ' at ' . now());

        Log::info('User updated: ' . $user->username . ' at ' . now());

        return redirect()->route('users')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Don't allow deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users')->with('error', 'No puedes eliminar tu propio usuario');
        }
        
        $user->delete();
        
        Log::info('User deleted successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('User deleted: ' . $user->username . ' at ' . now());

        return redirect()->route('users')->with('success', 'Usuario eliminado exitosamente');
    }
}
