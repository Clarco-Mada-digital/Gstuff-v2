<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
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

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name',
            ],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id']
        ], [
            'name.required' => __('roles.validation.name_required'),
            'name.unique' => __('roles.validation.name_unique'),
            'name.max' => __('roles.validation.name_max'),
            'permissions.array' => __('roles.validation.permissions_array'),
            'permissions.*.exists' => __('roles.validation.permissions_exists'),
        ]);
        
        $role = Role::create(['name' => $validated['name']]);
        
        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }
        
        return response()->json([
            'role' => $role,
            'message' => __('roles.role_created')
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

    public function editRole($id)
    {
        $this->authorize('manage roles');
        
        $role = Role::findOrFail($id)->load('permissions');
        $permissions = Permission::all();
        
        return view('admin.roles.editRole', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        \Log::info('Updating role', ['role_id' => $role->id, 'role_name' => $role->name]);
        \Log::info('Request data', ['all' => $request->all()]);
        $this->authorize('manage roles');

        // Empêcher la modification du rôle admin sauf par un admin
        if ($role->name === 'admin' && !auth()->user()->hasRole('admin')) {
            return redirect()->route('roles.index')->with('error', __('roles.admin_role_protected'));
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($role->id),
            ],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['exists:permissions,name']
        ], [
            'name.required' => __('roles.validation.name_required'),
            'name.unique' => __('roles.validation.name_unique'),
            'name.max' => __('roles.validation.name_max'),
            'permissions.array' => __('roles.validation.permissions_array'),
            'permissions.*.exists' => __('roles.validation.permissions_exists'),
        ]);

        if (isset($validated['name'])) {
            $role->name = $validated['name'];
            $role->save();
        }

        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('roles.index')->with('success', __('roles.role_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
       public function destroy(string $id)
    {    
        $this->authorize('manage roles');
        
        $role = Role::findOrFail($id);
        
        // Empêcher la suppression du rôle admin
        if ($role->name === 'admin') {
            return response()->json([
                'success' => false,
                'message' => __('roles.delete_admin_denied')
            ], 403);
        }
        
        // Empêcher un utilisateur de supprimer son propre rôle
        if (auth()->user()->roles->contains('id', $role->id)) {
            return response()->json([
                'success' => false,
                'message' => __('roles.delete_self_denied')
            ], 403);
        }
        
        try {
            $role->delete();
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => __('roles.role_deleted')
                ]);
            }
            
            return redirect()->route('roles.index')
                ->with('success', __('roles.role_deleted'));
                
        } catch (\Exception $e) {
            \Log::error('Error deleting role: ' . $e->getMessage());
            
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }
}