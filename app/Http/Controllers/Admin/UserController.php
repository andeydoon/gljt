<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Krucas\Notification\Facades\Notification;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        Notification::success('新用户创建成功');

        return redirect()->route('admin.user.edit', $user);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::with('profile')->where('id', $id)->first();

        $roles = Role::all();

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->mobile = $request->mobile;
        $user->status = $request->status;
        $user->type = $request->type;
        $user->save();

        $userProfile = $user->profile;
        $userProfile->realname = $request->profile['realname'];
        $userProfile->save();

        $user->roles()->sync([]);
        if ($request->has('roles')) {
            foreach ($request->roles as $role) {
                $user->attachRole(Role::where('name', $role)->first());
            }
        }
        $user->save();

        Notification::success('用户编辑成功');

        return redirect()->route('admin.user.edit', $user);
    }

    public function destroy($id)
    {
        //
    }
}
