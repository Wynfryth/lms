<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index($users_kywd = null)
    {
        $users = DB::table('users AS a')
            ->select('a.id', 'a.email', 'a.name AS username', 'c.name AS rolename', 'a.is_active')
            ->leftJoin('model_has_roles AS b', 'b.model_id', '=', 'a.id')
            ->leftJoin('roles AS c', 'c.id', '=', 'b.role_id');
        if ($users_kywd != null) {
            $any_params = [
                'a.email',
                'a.name',
                'c.name',
            ];
            $users->whereAny($any_params, 'like', '%' . $users_kywd . '%');
        }
        $users = $users->paginate(10);
        return view('user.index', compact('users', 'users_kywd'));
    }

    public function edit($id)
    {
        $user_id = $id;
        $user_data = DB::table('users AS a')
            ->select('a.id', 'a.email', 'a.name AS username', 'c.id AS roleid', 'c.name AS rolename', 'a.is_active')
            ->leftJoin('model_has_roles AS b', 'b.model_id', '=', 'a.id')
            ->leftJoin('roles AS c', 'c.id', '=', 'b.role_id')
            ->where('a.id', $user_id)
            ->first();
        $roles = DB::table('roles AS a')
            ->get();
        return view('user.edit', compact('user_id', 'user_data', 'roles'));
    }

    public function update(Request $request, $id)
    {
        isset($request->active_status) ? $active_status = 1 : $active_status = 0;
        $update_data = [
            'name' => $request->nama,
            'email' => $request->email,
            'updated_at' => Carbon::now(),
            'is_active' => $active_status
        ];
        $update_action = DB::table('users AS a')
            ->where('a.id', $id)
            ->update($update_data);
        $user = User::where(['id' => $id])->first();
        $role = Role::where(['id' => $request->role])->first();
        $user->roles()->detach();
        $user->assignRole($role);
        return $update_action;
    }
}
