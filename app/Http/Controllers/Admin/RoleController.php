<?php
// app/Http/Controllers/Admin/RoleController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:roles',
            'permissions'=>'required|array'
        ]);

        $role = Role::create(['name'=>$request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role','permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>'required',
            'permissions'=>'required|array'
        ]);

        $role->update(['name'=>$request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index');
    }
}
