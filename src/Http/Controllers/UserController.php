<?php

namespace Danhermes\BreadForLaravel\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Danhermes\BreadForLaravel\Models\Role;
use Danhermes\BreadForLaravel\Models\Bread;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        return view('BreadPermissions::users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::orderBy('name', 'DESC')->get();

        return view('BreadPermissions::users.show', compact('roles', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::orderBy('name', 'DESC')->get();

        return view('BreadPermissions::users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:users,name,' . $id,
            'email' => 'required|email|max:50|unique:users,email,' . $id,
        ]);

        // Buscamos y despues actualizamos el usuario
        $user = User::findOrFail($id);
        
        $user->update($request->all());

        $user->roles()->sync($request->role_id);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscamos y despues eliminamos el usuario
        $user = User::findOrFail($id);

        $user->delete();
    }
}
