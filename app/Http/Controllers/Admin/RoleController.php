<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('manage roles');
        
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        
        return view('admin.roles.index', compact('roles', 'permissions'));
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
        $this->authorize('manage roles');

        $request->validate([
            'name' => 'required|unique:roles|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);
        
        $role = Role::create(['name' => $request->name]);
        
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }
        
        return response()->json([
            'role' => $role,
            'message' => 'Role creer avec success !'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'admin' && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'permissions.*' => 'exists:permissions,name'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {    
        // Méthode 2 - Avec findOrFail (recommandée)
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé');
        
        // Méthode 3 - Avec suppression statique
    //     Role::destroy($id);
    //     return redirect()->route('roles.index')->with('success', 'Rôle supprimé');
    // }
    }
}