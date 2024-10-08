<?php

namespace App\Http\Controllers;

use App\Models\Studies;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            ->select('a.id', 'a.study_material_title', 'a.study_material_desc', 'b.study_material_category', 'a.is_active')
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

        $insert_data = [
            'study_material_title' => $request->judul_materi,
            'study_material_desc' => $request->deskripsi_materi,
            'category_id' => $request->kategori_materi,
            'is_active' => 1,
            'created_by' => Auth::user()->name,
            'created_date' => Carbon::now()
        ];

        $insert_action = DB::table('tm_study_material_header')
            ->insertGetId($insert_data);

        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('academy_admin.studies.index')->with($status);
        }
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

        $sql_detail = "SELECT
                        a.id, a.name, a.order, a.scoring_weight,
                        IF(GROUP_CONCAT(b.filename SEPARATOR ' ') IS NOT NULL, GROUP_CONCAT(b.filename SEPARATOR ', '), '-') AS filename,
                        IF(GROUP_CONCAT(b.attachment SEPARATOR ' ') IS NOT NULL, GROUP_CONCAT(b.attachment SEPARATOR ', '), '-') AS attachment,
                        IF(GROUP_CONCAT(b.estimated_time SEPARATOR ' ') IS NOT NULL, GROUP_CONCAT(b.estimated_time SEPARATOR ', '), '-') AS estimated_time
                        FROM tm_study_material_detail a
                        LEFT JOIN tm_study_material_attachments b ON b.study_material_detail_id = a.id
                        WHERE a.header_id = ?
                        AND a.is_active = 1
                        GROUP BY a.id
                        ORDER BY a.order ASC";
        $param_detail = [
            $id
        ];
        $detail = DB::select($sql_detail, $param_detail);
        foreach ($detail as $key => $value) {
            if (substr($value->attachment, 0, 4) != 'http') {
                $value->attachment = Storage::url($value->attachment);
            }
        }

        return view('academy_admin.studies.edit', compact('item', 'kategori', 'detail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
        $update_data = [
            'study_material_title' => $request->judul_materi,
            'study_material_desc' => $request->deskripsi_materi,
            'category_id' => $request->kategori_materi,
            // 'is_active' => 1,
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $update_action = DB::table('tm_study_material_header AS a')
            ->where('a.id', $id)
            ->update($update_data);
        if (isset($request->detail_sequence)) {
            foreach ($request->detail_sequence as $key => $value) {
                // return $value;
                $update_data = [
                    'a.order' => intval($key) + 1
                ];
                $update_detail_sequence = DB::table('tm_study_material_detail AS a')
                    ->where('a.id', $value)
                    ->update($update_data);
            }
        }
        // return $request->detail_sequence;
        if ($update_action > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengubah data!'
            ];
            return redirect()->route('academy_admin.studies.index')->with($status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Studies $studies)
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
        $delete_action = DB::table('tm_study_material_header AS a')
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
        $recover_action = DB::table('tm_study_material_header AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($recover_action > 0) {
            return $recover_action;
        } else {
            return 'failed to recover';
        }
    }
}
