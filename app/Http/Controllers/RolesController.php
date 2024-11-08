<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index($roles_kywd = null)
    {
        $roles = DB::table('roles AS a')
            ->select('a.id', 'a.name')
            ->selectRaw(DB::raw('GROUP_CONCAT(c.name) AS granted_permissions'))
            ->leftJoin('role_has_permissions AS b', 'b.role_id', '=', 'a.id')
            ->leftJoin('permissions AS c', 'c.id', '=', 'b.permission_id')
            ->groupBy('a.id');
        if ($roles_kywd != null) {
            $any_params = [
                'a.name',
            ];
            $roles->whereAny($any_params, 'like', '%' . $roles_kywd . '%');
        }
        $roles = $roles->paginate(10);
        return view('roles.index', compact('roles', 'roles_kywd'));
    }

    public function create()
    {
        $permissions = DB::table('permissions AS a')
            ->orderBy(DB::raw("CASE
                WHEN name LIKE 'view%' THEN 1
                WHEN name LIKE 'list%' THEN 2
                WHEN name LIKE 'create%' THEN 3
                WHEN name LIKE 'edit%' THEN 4
                WHEN name LIKE 'delete%' THEN 5
                ELSE 6
                END"))
            ->get();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role_name' => 'required',
            ],
            [
                'role_name.required' => 'Nama role belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $data = $request->all();
        $role = Role::create(['name' => $request->role_name]);
        foreach ($data as $key => $item) {
            if (substr($key, 0, 5) == 'perm_') {
                $permission = Permission::where('id', explode('_', $key)[1])->first();
                $role->givePermissionTo($permission);
            }
        };
        // on done
        $status = [
            'status' => 'insert',
            'status_message' => 'Berhasil menambah data!'
        ];
        return redirect()->route('roles')->with($status);
    }

    public function edit($id)
    {
        $role_id = $id;
        $role_data = DB::table('roles AS a')
            ->select('a.id', 'a.name')
            ->selectRaw(DB::raw('GROUP_CONCAT(c.id) AS granted_permissions'))
            ->leftJoin('role_has_permissions AS b', 'b.role_id', '=', 'a.id')
            ->leftJoin('permissions AS c', 'c.id', '=', 'b.permission_id')
            ->where('a.id', $id)
            ->groupBy('a.id')
            ->first();
        $permissions = DB::table('permissions AS a')
            ->orderBy(DB::raw("CASE
                WHEN name LIKE 'view%' THEN 1
                WHEN name LIKE 'list%' THEN 2
                WHEN name LIKE 'create%' THEN 3
                WHEN name LIKE 'edit%' THEN 4
                WHEN name LIKE 'delete%' THEN 5
                ELSE 6
                END"))
            ->get();
        return view('roles.edit', compact('role_id', 'role_data', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role_name' => 'required',
            ],
            [
                'role_name.required' => 'Nama role belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $data = $request->all();
        $role = Role::find($id);
        $role->name = $request->role_name;
        $role->save();
        $role->permissions()->detach();
        foreach ($data as $key => $item) {
            if (substr($key, 0, 5) == 'perm_') {
                $permission = Permission::where('id', explode('_', $key)[1])->first();
                $role->givePermissionTo($permission);
            }
        };
        // on done
        $status = [
            'status' => 'update',
            'status_message' => 'Berhasil mengedit data!'
        ];
        return redirect()->route('roles')->with($status);
    }
}
