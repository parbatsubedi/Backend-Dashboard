<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function view()
    {
        $roles = Role::with('permissions')->paginate(10);
        //dd($roles);

        return view('admin.role.view')->with(compact('roles'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {

            $role = Role::create(['name' => $request->name]);
            $role->givePermissionTo($request->permissions);

            return redirect(route('role.view'));
        }

        $allPermissions = Permission::get();

        return view('admin.role.create')->with(compact('allPermissions'));
    }

    public function edit($id, Request $request)
    {
        $role = Role::where('id', $id)->firstOrFail();
        $permissions = $role->getAllPermissions();
        $allPermissions = Permission::get();

        if ($request->isMethod('post')) {
            $allPermissionsName = $allPermissions->map(function ($item, $key) {
                return $item->name;
            })->toArray();

            $role->name = $request->name;
            $role->save();

            $role->revokePermissionTo($allPermissionsName);
            $role->givePermissionTo($request->permissions);

            return redirect(route('role.view'));

        }

        return view('admin.role.edit')->with(compact('role', 'permissions', 'allPermissions'));

    }
}
