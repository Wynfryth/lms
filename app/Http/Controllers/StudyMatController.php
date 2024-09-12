<?php

namespace App\Http\Controllers;

use App\Models\StudyMat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudyMatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studymat = DB::table('tm_study_material_detail AS a')
            ->leftJoin('tm_study_material_header AS b', 'b.id', '=', 'a.header_id')
            ->orderBy('a.id')
            ->get();
        return view('academy_admin.studymat.index', compact('studymat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tajuk = DB::table('tm_study_material_header AS a')
            ->where('a.is_active', 1)
            ->get();
        return view('academy_admin.studymat.create', compact('tajuk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StudyMat $studyMat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudyMat $studyMat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudyMat $studyMat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyMat $studyMat)
    {
        //
    }
}
