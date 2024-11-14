<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TestsController extends Controller
{
    public function index($tests_kywd = null)
    {
        $tests = DB::table('tm_test AS a')
            ->select('a.id', 'b.test_category', 'a.test_code', 'a.test_name', 'b.test_category', 'a.test_desc', 'a.is_active')
            ->leftJoin('tm_test_category AS b', 'b.id', '=', 'a.test_cat_id')
            ->orderByDesc('a.id');
        if ($tests_kywd != null) {
            $any_params = [
                'b.test_category',
                'a.test_code',
                'a.test_name',
                'a.test_desc'
            ];
            $tests->whereAny($any_params, 'like', '%' . $tests_kywd . '%');
        }
        $tests = $tests->paginate(10);
        return view('tests_view.index', compact('tests', 'tests_kywd'));
    }

    public function create()
    {
        $testcats = DB::table('tm_test_category AS a')
            ->select('a.id', 'a.test_category')
            ->orderBy('a.id')
            ->get();
        return view('tests_view.create', compact('testcats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_tes' => 'required',
                'kategori_tes' => 'required',
                'deskripsi_tes' => 'required',
            ],
            [
                'nama_tes.required' => 'Nama tes belum terisi.',
                'kategori_tes.required' => 'Kategori tes belum terisi.',
                'deskripsi_tes.required' => 'Deskripsi tes belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $insert_data = [
            'test_cat_id' => $request->kategori_tes,
            'test_name' => $request->nama_tes,
            'test_desc' => $request->deskripsi_tes,
            'is_active' => 1,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('tm_test')
            ->insertGetId($insert_data);
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('tests')->with($status);
        }
    }

    public function edit($id)
    {
        $item = DB::table('tm_test AS a')
            ->select('a.id', 'b.test_category', 'a.test_code', 'a.test_name', 'a.test_desc', 'a.is_active')
            ->leftJoin('tm_test_category AS b', 'b.id', '=', 'a.test_cat_id')
            ->where('a.id', $id)
            ->first();
        $testcats = DB::table('tm_test_category AS a')
            ->select('a.id', 'a.test_category')
            ->orderBy('a.id')
            ->get();
        return view('tests_view.edit', compact('item', 'testcats'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_tes' => 'required',
                'kategori_tes' => 'required',
                'deskripsi_tes' => 'required',
            ],
            [
                'nama_tes.required' => 'Nama tes belum terisi.',
                'kategori_tes.required' => 'Kategori tes belum terisi.',
                'deskripsi_tes.required' => 'Deskripsi tes belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        };
        $update_data = [
            'test_cat_id' => $request->kategori_tes,
            'test_name' => $request->nama_tes,
            'test_desc' => $request->deskripsi_tes,
            'is_active' => 1,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_action = DB::table('tm_test')
            ->update($update_data);
        if ($update_action > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengubah data!'
            ];
            return redirect()->route('tests')->with($status);
        }
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $delete_action = DB::table('tm_test AS a')
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
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $recover_action = DB::table('tm_test AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($recover_action > 0) {
            return $recover_action;
        } else {
            return 'failed to recover';
        }
    }
}
