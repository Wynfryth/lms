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
    public function index($studies_kywd = null)
    {
        $studies = DB::table('tm_study_material_header AS a')
            ->select('a.id', 'a.study_material_title', 'a.study_material_desc', 'b.study_material_category', 'a.is_active')
            ->selectRaw('GROUP_CONCAT(e.id) AS kategori_tes, GROUP_CONCAT(d.test_name) AS tests, f.pembelajaran, f.attachments, f.total_waktu')
            ->leftJoin('tm_study_material_category AS b', 'b.id', '=', 'a.category_id')
            ->leftJoin('t_test_with_materials_list AS c', 'c.study_materials_id', '=', 'a.id')
            ->leftJoin('tm_test AS d', 'd.id', '=', 'c.test_id')
            ->leftJoin('tm_test_category AS e', 'e.id', '=', 'd.test_cat_id')
            ->leftJoin(DB::raw('(SELECT
                a.id, GROUP_CONCAT(b.name) AS pembelajaran, GROUP_CONCAT(c.filename) AS attachments, SEC_TO_TIME( SUM( TIME_TO_SEC(c.estimated_time) ) ) AS total_waktu
                FROM tm_study_material_header AS a
                LEFT JOIN tm_study_material_detail AS b ON b.header_id = a.id AND b.is_active = 1
                LEFT JOIN tm_study_material_attachments AS c ON c.study_material_detail_id = b.id
                GROUP BY a.id) AS f'), 'f.id', '=', 'a.id')
            ->leftJoin('tm_study_material_attachments AS g', 'g.study_material_detail_id', '=', 'f.id')
            ->orderByDesc('a.id')
            ->groupBy('a.id');
        if ($studies_kywd != null) {
            $any_params = [
                'a.study_material_title',
                'a.study_material_desc'
            ];
            $studies->whereAny($any_params, 'like', '%' . $studies_kywd . '%');
        }
        $studies = $studies->paginate(10);

        return view('studies.index', compact('studies', 'studies_kywd'));
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
        return view('studies.create', compact('kategori'));
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
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];

        $insert_action = DB::table('tm_study_material_header')
            ->insertGetId($insert_data);

        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('studies')->with($status);
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

        return view('studies.edit', compact('item', 'kategori', 'detail'));
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
            'modified_by' => Auth::id(),
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
            return redirect()->route('studies')->with($status);
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
            'modified_by' => Auth::id(),
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
            'modified_by' => Auth::id(),
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
