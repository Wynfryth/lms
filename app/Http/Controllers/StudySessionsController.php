<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudySessionsController extends Controller
{
    public function index($studyId)
    {
        $study = DB::table('tm_study_material_header as a')
            ->select('a.*', 'a.id AS studyId', 'b.*', 'c.*') // Select all columns or specify required ones
            ->leftJoin('tm_study_material_detail as b', 'b.header_id', '=', 'a.id')
            ->leftJoin('tm_study_material_attachments as c', 'c.study_material_detail_id', '=', 'b.id')
            ->where('a.id', $studyId)
            ->get();
        return view('classrooms.studySession', compact('study'));
    }
}
