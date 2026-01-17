<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Core\RBAC\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->groupBy('group_name');
        $roles = \App\Core\RBAC\Models\Role::where('name', '!=', 'Super Admin')->get();
        
        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    public function updateMatrix(Request $request)
    {
        $matrix = $request->input('matrix', []);
        
        $roles = \App\Core\RBAC\Models\Role::where('name', '!=', 'Super Admin')->get();

        foreach ($roles as $role) {
            if (isset($matrix[$role->id])) {
                // array of permission IDs
                $role->permissions()->sync($matrix[$role->id]);
            } else {
                // If role ID is not in matrix, it means no permissions (or all unchecked)
                // BUT we need to be careful. The matrix only sends checked boxes usually.
                // It is safer to re-construct the sync array.
                // Actually, if a checkbox is unchecked, it won't be sent.
                // So for each role, we define a list of permissions based on what's present in $request->matrix[role_id]
                $role->permissions()->sync([]);
            }
        }

        return redirect()->route('admin.permissions.index')->with('success', 'Permissions updated successfully.');
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'group_name' => 'required|string'
        ]);

        Permission::create($request->only('name', 'group_name'));

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
         $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'group_name' => 'required|string'
        ]);

        $permission->update($request->only('name', 'group_name'));

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permission deleted successfully.');
    }
}
