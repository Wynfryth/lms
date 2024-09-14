<?php

namespace App\Http\Controllers;

use App\Models\StudyDet;
use Illuminate\Http\Request;

class StudyDetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academy_admin.studydet.create');
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
    public function show(StudyDet $studyDet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudyDet $studyDet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudyDet $studyDet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyDet $studyDet)
    {
        //
    }

    public function delete() {}

    public function recover()
    {
        //
    }

    public function attachment()
    {
        return view('academy_admin.studydet.attachment-row');
    }
}
