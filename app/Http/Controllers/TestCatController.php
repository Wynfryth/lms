<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TestCatController extends Controller
{
    public function index($testcat_kywd = null)
    {
        $testcats = DB::table('tm_test_category AS a')
            ->orderByDesc('a.id');
        if ($testcat_kywd != null) {
            $any_params = [
                'a.test_category',
                'a.desc'
            ];
            $testcats->whereAny($any_params, 'like', '%' . $testcat_kywd . '%');
        }
        $testcats = $testcats->paginate(10);
        return view('testcat.index', compact('testcats', 'testcat_kywd'));
    }

    public function create()
    {
        return view('testcat.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori_tes' => 'required',
                'deskripsi_kategori_tes' => 'required',
            ],
            [
                'kategori_tes.required' => 'Kategori tes belum terisi.',
                'deskripsi_kategori_tes.required' => 'Deskripsi kategori tes belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $insert_data = [
            'test_category' => $request->kategori_tes,
            'desc' => $request->deskripsi_kategori_tes,
            'is_active' => 1,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('tm_test_category')
            ->insertGetId($insert_data);
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('testcat')->with($status);
        }
    }

    public function edit($id)
    {
        $item = DB::table('tm_test_category AS a')
            ->where('a.id', $id)
            ->first();
        return view('testcat.edit', compact('item'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori_tes' => 'required',
                'deskripsi_kategori_tes' => 'required',
            ],
            [
                'kategori_tes.required' => 'Kategori tes belum terisi.',
                'deskripsi_kategori_tes.required' => 'Deskripsi kategori tes belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $update_data = [
            'test_category' => $request->kategori_tes,
            'desc' => $request->deskripsi_kategori_tes,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_test_category AS a')
            ->where('a.id', $id)
            ->update($update_data);
        if ($update_affected > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengubah data!'
            ];
            return redirect()->route('testcat')->with($status);
        }
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $delete_action = DB::table('tm_test_category AS a')
            ->where('a.id', $request->id)
            ->update($delete_data);
        if ($delete_action > 0) {
            return $delete_action;
        } else {
            return 'failed to delete';
        }
    }

    public function recover(Request $request)
    {
        $recover_data = [
            'is_active' => 1,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $recover_action = DB::table('tm_test_category AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($recover_action > 0) {
            return $recover_action;
        } else {
            return 'failed to recover';
        }
    }
}
