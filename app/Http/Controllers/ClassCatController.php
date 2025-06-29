<?php

namespace App\Http\Controllers;

use App\Models\ClassCat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ClassCatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($classcat_kywd = null)
    {
        $classcat = DB::table('tm_class_category AS a')
            ->select('a.id', 'a.class_category', 'a.desc', 'a.is_active', 'b.category_type')
            ->leftJoin('tm_class_category_type AS b', 'b.id', '=', 'a.class_category_type_id')
            // ->where('a.is_active', 1)
            ->orderBy('a.id', 'desc');
        if ($classcat_kywd != null) {
            $any_params = [
                'a.id',
                'a.class_category',
                'a.desc',
                'a.is_active'
            ];
            $classcat->whereAny($any_params, 'like', '%' . $classcat_kywd . '%');
        }
        $classcat = $classcat->paginate(10);
        return view('classcat.index', compact('classcat', 'classcat_kywd'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classcat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori_kelas' => 'required',
                'deskripsi_kategori_kelas' => 'required'
            ],
            [
                'kategori_kelas.required' => 'Kategori kelas belum terisi.',
                'deskripsi_kategori_kelas.required' => 'Deskripsi kategori kelas belum terisi.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $insert_data = [
            'class_category' => $request->kategori_kelas,
            'desc' => $request->deskripsi_kategori_kelas,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('tm_class_category')
            ->insertGetId($insert_data);
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('classcat')->with($status);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassCat $classCat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = DB::table('tm_class_category AS a')
            ->where('a.id', $id)
            ->first();
        return view('classcat.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori_kelas' => 'required',
                'deskripsi_kategori_kelas' => 'required'
            ],
            [
                'kategori_kelas.required' => 'Kategori kelas belum terisi.',
                'deskripsi_kategori_kelas.required' => 'Deskripsi kategori kelas belum terisi.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $update_data = [
            'class_category' => $request->kategori_kelas,
            'desc' => $request->deskripsi_kategori_kelas,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_class_category AS a')
            ->where('a.id', $id)
            ->update($update_data);
        if ($update_affected > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengubah data!'
            ];
            return redirect()->route('classcat')->with($status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_class_category AS a')
            ->where('a.id', $id)
            ->update($delete_data);
        if ($update_affected > 0) {
            return redirect()->route('classcat');
        }
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_class_category AS a')
            ->where('a.id', $request->id)
            ->update($delete_data);
        if ($update_affected > 0) {
            return $update_affected;
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
        $update_affected = DB::table('tm_class_category AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($update_affected > 0) {
            return $update_affected;
        } else {
            return 'failed to recover';
        }
    }
}
