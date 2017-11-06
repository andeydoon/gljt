<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Krucas\Notification\Facades\Notification;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role.index');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->permissions()->sync([]);
        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission) {
                $role->attachPermission(Permission::where('name', $permission)->first());
            }
        }
        $role->save();

        Notification::success('角色编辑成功');

        return redirect()->route('admin.role.edit', $role);
    }
}
