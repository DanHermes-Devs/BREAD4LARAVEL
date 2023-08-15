<?php

namespace Danhermes\BreadForLaravel\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Danhermes\BreadForLaravel\Models\Role;
use Danhermes\BreadForLaravel\Models\Bread;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate(10);
        
        return view('BreadPermissions::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breads = Bread::with('permissions')->get();

        return view('BreadPermissions::roles.create', compact('breads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'full_access' => 'required|in:yes,no',
        ]);
        
        // Creamos el rol
        $role = Role::create([
            'name' => $request->name,
            'full_access' => $request->full_access,
        ]);

        // Asignamos los permisos
        if($request->permissions){
            $role->permissions()->sync($request->permissions);
        }        

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Role::findOrfail($id);

        $permission_role =[];

        foreach ($role->permissions as $permission) {
            $permission_role[] = $permission->id;
        }

        $breads = Bread::with('permissions')->get();

        return view('BreadPermissions::roles.show', compact('breads', 'role', 'permission_role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::findOrfail($id);

        $permission_role =[];

        foreach ($role->permissions as $permission) {
            $permission_role[] = $permission->id;
        }

        $breads = Bread::with('permissions')->get();

        return view('BreadPermissions::roles.edit', compact('breads', 'role', 'permission_role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'full_access' => 'required|in:yes,no',
        ]);
        
        // Buscamos y despues Actualizamos el rol
        $role = Role::findOrfail($id);

        $role->update([
            'name' => $request->name,
            'full_access' => $request->full_access,
        ]);

        // Asignamos los permisos
        if($request->permissions){
            $role->permissions()->sync($request->permissions);
        }        

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscamos y despues eliminamos el rol
        $role = Role::findOrfail($id);

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente');
    }
}
