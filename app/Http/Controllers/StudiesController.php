<?php

namespace App\Http\Controllers;

use App\Models\Studies;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studies = DB::table('tm_study_material_header AS a')
            ->leftJoin('tm_study_material_category AS b', 'a.category_id', '=', 'b.id')
            ->select('a.id', 'a.study_material_title', 'a.study_material_desc', 'b.study_material_category')
            // ->where('a.is_active', 1)
            ->orderByDesc('a.id')
            ->get();

        return view('academy_admin.studies.index', compact('studies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = DB::table('tm_study_material_category AS a')
            ->where('a.is_active', 1)
            ->orderBy('a.id', 'asc')
            ->get();
        return view('academy_admin.studies.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'judul_materi' => 'required',
                'deskripsi_materi' => 'required',
                'kategori_materi' => 'required'
            ],
            [
                'judul_materi.required' => 'Judul materi belum terisi.',
                'deskripsi_materi.required' => 'Deskripsi materi belum terisi.',
                'kategori_materi.required' => 'Kategori materi belum terisi.'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $studies = new Studies();
        $studies->study_material_title = $request->judul_materi;
        $studies->study_material_desc = $request->deskripsi_materi;
        $studies->category_id = $request->kategori_materi;
        $studies->is_active = 1;
        $studies->created_by = Auth::user()->name;
        $studies->created_date = Carbon::now();
        $studies->save();

        return redirect()->route('academy_admin.studies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Studies $studies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = DB::table('tm_study_material_header AS a')
            ->where('a.id', $id)
            ->first();

        $kategori = DB::table('tm_study_material_category AS a')
            ->where('a.is_active', 1)
            ->orderBy('a.id', 'asc')
            ->get();

        return view('academy_admin.studies.edit', compact('item', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Studies $studies)
    {
        //
    }

    public function delete(Request $request) {}
}
