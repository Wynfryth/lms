<?php

namespace App\Http\Controllers;

use App\Models\StudyDet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                'estimated_time' => $value->durasi,
                'attachment' => $value->file_pembelajaran,
                'is_active' => 1,
                'created_by' => Auth::user()->name,
                'created_date' => Carbon::now()
            ];
            $insert_att = DB::table('tm_study_material_attachments')
                ->insertGetId($insert_att);
            // return $insert_att;
        }
        return $insert_action;
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
    public function edit($id)
    {
        $item['id'] = $id;
        $where_params = [
            [
                'a.study_material_detail_id',
                '=',
                $id
            ]
        ];
        $attachments = DB::table('tm_study_material_attachments AS a')
            ->where($where_params)
            ->get();

        return view('academy_admin.studydet.edit', compact('item', 'attachments'));
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

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_study_material_detail AS a')
            ->where('a.id', $request->id)
            ->update($delete_data);
        if ($update_affected > 0) {
            return $update_affected;
            // $status = [
            //     'status' => 'delete',
            //     'status_message' => 'Berhasil mengapus detail!'
            // ];
            // return redirect()->route('academy_admin.studies.edit', $request->id_header)->with($status);
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
        $update_affected = DB::table('tm_study_material_detail AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($update_affected > 0) {
            return $update_affected;
            // $status = [
            //     'status' => 'delete',
            //     'status_message' => 'Berhasil mengapus detail!'
            // ];
            // return redirect()->route('academy_admin.studies.edit', $request->id_header)->with($status);
        } else {
            return 'failed to recover';
        }
    }

    public function attachment()
    {
        return view('academy_admin.studydet.attachment-row');
    }

    public function get_deleted(Request $request)
    {
        $sql_detail = "SELECT
                        a.id, a.header_id, a.name, a.order, a.scoring_weight,
                        IF(GROUP_CONCAT(b.filename SEPARATOR ' ') IS NOT NULL, GROUP_CONCAT(b.filename SEPARATOR ', '), '-') AS filename,
                        IF(GROUP_CONCAT(b.attachment SEPARATOR ' ') IS NOT NULL, GROUP_CONCAT(b.attachment SEPARATOR ', '), '-') AS attachment,
                        IF(GROUP_CONCAT(b.estimated_time SEPARATOR ' ') IS NOT NULL, GROUP_CONCAT(b.estimated_time SEPARATOR ', '), '-') AS estimated_time
                        FROM tm_study_material_detail a
                        LEFT JOIN tm_study_material_attachments b ON b.study_material_detail_id = a.id
                        WHERE a.header_id = ?
                        AND a.is_active = 0
                        GROUP BY a.id";
        $param_detail = [
            $request->id
        ];
        $detail = DB::select($sql_detail, $param_detail);
        if (count($detail) > 0) {
            foreach ($detail as $key => $value) {
                if (substr($value->attachment, 0, 4) != 'http') {
                    $value->attachment = Storage::url($value->attachment);
                }
            }
        } else {
            $detail = [];
        }

        return view('academy_admin.studydet.get_deleted', compact('detail'));
    }
}
