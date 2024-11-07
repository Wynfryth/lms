<?php

namespace App\Http\Controllers;

use App\Models\StudyCat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudyCatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($studycat_kywd = null)
    {
        $studycat = DB::table('tm_study_material_category AS a')
            // ->where('a.is_active', 1)
            ->orderBy('a.id', 'desc');
        if ($studycat_kywd != null) {
            $any_params = [
                'a.study_material_category',
                'a.desc',
            ];
            $studycat->whereAny($any_params, 'like', '%' . $studycat_kywd . '%');
        }
        $studycat = $studycat->paginate(10);

        return view('studycat.index', compact('studycat', 'studycat_kywd'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('studycat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori_materi' => 'required',
                'deskripsi_kategori_materi' => 'required'
            ],
            [
                'kategori_materi.required' => 'Kategori materi belum terisi.',
                'deskripsi_kategori_materi.required' => 'Deskripsi kategori materi belum terisi.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $insert_data = [
            'study_material_category' => $request->kategori_materi,
            'desc' => $request->deskripsi_kategori_materi,
            'created_by' => Auth::user()->name,
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('tm_study_material_category')
            ->insertGetId($insert_data);
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('studycat')->with($status);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StudyCat $studyCat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = DB::table('tm_study_material_category AS a')
            ->where('a.id', $id)
            ->first();
        return view('studycat.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori_materi' => 'required',
                'deskripsi_kategori_materi' => 'required'
            ],
            [
                'kategori_materi.required' => 'Kategori materi belum terisi.',
                'deskripsi_kategori_materi.required' => 'Deskripsi kategori materi belum terisi.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $update_data = [
            'study_material_category' => $request->kategori_materi,
            'desc' => $request->deskripsi_kategori_materi,
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_study_material_category AS a')
            ->where('a.id', $id)
            ->update($update_data);
        if ($update_affected > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengubah data!'
            ];
            return redirect()->route('studycat')->with($status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyCat $studyCat)
    {
        //
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_study_material_category AS a')
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
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_study_material_category AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($update_affected > 0) {
            return $update_affected;
        } else {
            return 'failed to recover';
        }
    }
}
