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
    public function index()
    {
        $studycat = DB::table('tm_study_material_category AS a')
            ->where('a.is_active', 1)
            ->orderBy('a.id', 'desc')
            ->get();

        return view('academy_admin.studycat.index', compact('studycat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academy_admin.studycat.create');
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

        $studycat = new StudyCat();
        $studycat->study_material_category = $request->kategori_materi;
        $studycat->desc = $request->deskripsi_kategori_materi;
        $studycat->created_by = Auth::user()->name;
        $studycat->created_date = Carbon::now();
        $studycat->save();

        return redirect()->route('academy_admin.studycat.index');
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
        return view('academy_admin.studycat.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
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
            return redirect()->route('academy_admin.studycat.index');
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
}
