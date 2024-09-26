<?php

namespace App\Http\Controllers;

use App\Models\StudyDet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function create(Request $request)
    {
        $item['id'] = $request->id;
        return view('academy_admin.studydet.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $where_detail = [
            ['a.is_active', '=', 1],
            ['header_id', '=', $request->header_id]
        ];
        $order_detail = DB::table('tm_study_material_detail AS a')
            ->select([DB::raw('MAX(a.order) AS highest_order')])
            ->where($where_detail)
            ->first();
        $highest_order = $order_detail->highest_order;

        $insert_data = [
            'name' => $request->nama_pembelajaran,
            'header_id' => $request->header_id,
            'order' => $highest_order + 1,
            'is_active' => 1,
            'created_by' => Auth::user()->name,
            'created_date' => Carbon::now(),
            'scoring_weight' => $request->bobot_pembelajaran
        ];
        $insert_action = DB::table('tm_study_material_detail')
            ->insertGetId($insert_data);
        // return $insert_action;

        $attachments = json_decode($request->attachments);
        foreach ($attachments as $key => $value) {
            $insert_att = [
                'study_material_detail_id' => $insert_action,
                'filename' => $value->nama_file,
                'attachment' => $value->file_pembelajaran,
                'is_active' => 1,
                'created_by' => Auth::user()->name,
                'created_date' => Carbon::now()
            ];
            $insert_att = DB::table('tm_study_material_attachments')
                ->insertGetId($insert_att);
            // return $insert_att;
        }
        // udah bisa save tinggal returnnya apa nih
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
