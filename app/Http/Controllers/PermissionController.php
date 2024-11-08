<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index($permissions_kywd = null)
    {
        $permissions = DB::table('permissions AS a')
            ->select('a.id', 'a.name')
            ->selectRaw(DB::raw('GROUP_CONCAT(c.name) AS roles_granted'))
            ->leftJoin('role_has_permissions AS b', 'b.permission_id', '=', 'a.id')
            ->leftJoin('roles AS c', 'c.id', '=', 'b.role_id')
            ->groupBy('a.id');
        if ($permissions_kywd != null) {
            $any_params = [
                'a.name',
            ];
            $permissions->whereAny($any_params, 'like', '%' . $permissions_kywd . '%');
        }
        $permissions = $permissions->paginate(10);
        return view('permissions.index', compact('permissions', 'permissions_kywd'));
    }

    public function create()
    {
        $roles = DB::table('roles AS a')
            ->get();
        return view('permissions.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'permission_name' => 'required',
            ],
            [
                'permission_name.required' => 'Nama permission belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $data = $request->all();
        $permission = Permission::create(['name' => $request->permission_name]);
        foreach ($data as $key => $item) {
            if (substr($key, 0, 5) == 'role_') {
                $role = Role::where('id', explode('_', $key)[1])->first();
                $permission->assignRole($role);
            }
        };
        // on done
        $status = [
            'status' => 'insert',
            'status_message' => 'Berhasil menambah data!'
        ];
        return redirect()->route('permissions')->with($status);
    }

    public function edit(Request $request, $id)
    {
        $permission_id = $id;
        $permission_data = DB::table('permissions AS a')
            ->select('a.id', 'a.name')
            ->selectRaw(DB::raw('GROUP_CONCAT(c.id) AS roles_granted'))
            ->leftJoin('role_has_permissions AS b', 'b.permission_id', '=', 'a.id')
            ->leftJoin('roles AS c', 'c.id', '=', 'b.role_id')
            ->where('a.id', $id)
            ->groupBy('a.id')
            ->first();
        $roles = Role::all();
        return view('permissions.edit', compact('permission_id', 'permission_data', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'permission_name' => 'required',
            ],
            [
                'permission_name.required' => 'Nama permission belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $data = $request->all();
        $permission = Permission::find($id);
        $permission->name = $request->permission_name;
        $permission->save();
        $permission->roles()->detach();
        foreach ($data as $key => $item) {
            if (substr($key, 0, 5) == 'role_') {
                $role = Role::where('id', explode('_', $key)[1])->first();
                $permission->assignRole($role);
            }
        };
        // on done
        $status = [
            'status' => 'update',
            'status_message' => 'Berhasil mengedit data!'
        ];
        return redirect()->route('permissions')->with($status);
    }

    public function destroy() {}
}
