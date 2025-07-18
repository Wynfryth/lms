<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TestsController extends Controller
{
    public function index($tests_kywd = null)
    {
        $tests = DB::table('tm_test AS a')
            ->select('a.id', 'b.test_category', 'a.test_code', 'a.test_name', 'study_material_title', 'a.test_desc', 'a.estimated_time', 'a.is_active', 'a.pass_point', 'a.is_released')
            ->selectRaw(DB::raw('COUNT(d.id) AS jumlah_soal, IF(SUM(d.points) IS NULL, 0, SUM(d.points)) AS total_poin'))
            ->leftJoin('tm_test_category AS b', 'b.id', '=', 'a.test_cat_id')
            ->leftJoin('test_has_questions AS c', 'c.test_id', '=', 'a.id')
            ->leftJoin('tm_question_bank AS d', 'd.id', '=', 'c.question_id')
            ->leftJoin('t_test_with_materials_list AS e', 'e.test_id', '=', 'a.id')
            ->leftJoin('tm_study_material_header AS f', 'f.id', '=', 'e.study_materials_id')
            ->orderByDesc('a.id')
            ->groupBy('a.id');
        if ($tests_kywd != null) {
            $any_params = [
                'b.test_category',
                'a.test_code',
                'a.test_name',
                'a.test_desc'
            ];
            $tests->whereAny($any_params, 'like', '%' . $tests_kywd . '%');
        }
        $tests = $tests->paginate(10);
        return view('tests_view.index', compact('tests', 'tests_kywd'));
    }

    public function create()
    {
        $testcats = DB::table('tm_test_category AS a')
            ->select('a.id', 'a.test_category')
            ->where('a.is_active', 1)
            ->orderBy('a.id')
            ->get();
        $studies = DB::table('tm_study_material_header AS a')
            ->select('a.id', 'a.study_material_title')
            ->orderBy('a.id')
            ->get();
        return view('tests_view.create', compact('testcats', 'studies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_tes' => 'required',
                'kategori_tes' => 'required',
                'deskripsi_tes' => 'required',
                'durasi_tes' => 'required',
                // 'min_point' => 'required'
            ],
            [
                'nama_tes.required' => 'Nama tes belum terisi.',
                'kategori_tes.required' => 'Kategori tes belum terisi.',
                'deskripsi_tes.required' => 'Deskripsi tes belum terisi.',
                'durasi_tes.required' => 'Durasi tes belum terisi.',
                // 'min_point' => 'Nilai minimum belum terisi.'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $insert_data = [
            'test_cat_id' => $request->kategori_tes,
            'test_name' => $request->nama_tes,
            'test_desc' => $request->deskripsi_tes,
            'pass_point' => $request->min_point,
            'estimated_time' => $request->durasi_tes,
            'is_active' => 1,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('tm_test')
            ->insertGetId($insert_data);

        $testCode = "T" . sprintf("%03d", $insert_action);
        $update_code = DB::table('tm_test AS a')
            ->where('a.id', $insert_action)
            ->update([
                'a.test_code' => $testCode
            ]);
        // menautkan ke study material
        if ($request->kategori_tes != 1) {
            $insert_test_in_material_data = [
                'test_id' => $insert_action,
                'study_materials_id' => $request->materi,
                'created_by' => Auth::id(),
                'created_date' => Carbon::now()
            ];
            $insert_test_in_material_action = DB::table('t_test_with_materials_list')
                ->insertGetId($insert_test_in_material_data);
        }
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('tests')->with($status);
        }
    }

    public function edit($id)
    {
        $item = DB::table('tm_test AS a')
            ->select(
                'a.id',
                'a.test_cat_id',
                'a.test_code',
                'a.test_name',
                'a.test_desc',
                'a.estimated_time',
                'a.pass_point',
                'a.is_active',
                'c.study_materials_id'
            )
            ->selectRaw('SUM(e.points) AS max_point')
            ->leftJoin('tm_test_category AS b', 'b.id', '=', 'a.test_cat_id')
            ->leftJoin('t_test_with_materials_list AS c', 'c.test_id', '=', 'a.id')
            ->leftJoin('test_has_questions AS d', 'd.test_id', '=', 'a.id')
            ->leftJoin('tm_question_bank AS e', 'e.id', '=', 'd.question_id')
            ->where('a.id', $id)
            ->groupBy('a.id')
            ->first();
        $testcats = DB::table('tm_test_category AS a')
            ->select('a.id', 'a.test_category')
            ->orderBy('a.id')
            ->get();
        $studies = DB::table('tm_study_material_header AS a')
            ->select('a.id', 'a.study_material_title')
            ->orderBy('a.id')
            ->get();
        return view('tests_view.edit', compact('item', 'testcats', 'studies'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_tes' => 'required',
                'kategori_tes' => 'required',
                'deskripsi_tes' => 'required',
                'durasi_tes' => 'required',
                // 'min_point' => 'required'
            ],
            [
                'nama_tes.required' => 'Nama tes belum terisi.',
                'kategori_tes.required' => 'Kategori tes belum terisi.',
                'durasi_tes.required' => 'Durasi tes belum terisi.',
                // 'min_point' => 'Nilai minimum belum terisi.'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        };
        $update_data = [
            'test_cat_id' => $request->kategori_tes,
            'test_name' => $request->nama_tes,
            'test_desc' => $request->deskripsi_tes,
            // 'pass_point' => $request->min_point,
            'estimated_time' => $request->durasi_tes,
            'is_active' => 1,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_action = DB::table('tm_test AS a')
            ->where('a.id', $id)
            ->update($update_data);
        // menautkan ke study material
        DB::table('t_test_with_materials_list')
            ->where('test_id', $id)
            ->delete();
        if ($request->kategori_tes != 1) {
            $update_test_in_material_data = [
                'test_id' => $id,
                'study_materials_id' => $request->materi,
                'created_by' => Auth::id(),
                'created_date' => Carbon::now()
            ];
            $update_test_in_material_action = DB::table('t_test_with_materials_list')
                // ->where(['test_id' => $id, 'study_materials_id' => $request->materi])
                ->insert($update_test_in_material_data);
        }
        // else {
        //     DB::table('t_test_with_materials_list')
        //         ->where(['test_id' => $id, 'study_materials_id' => $request->materi])
        //         ->delete();
        // }
        if ($update_action > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengubah data!'
            ];
            return redirect()->route('tests')->with($status);
        }
    }

    public function release(Request $request)
    {
        $releaseTest = DB::table('tm_test AS a')
            ->where('a.id', $request->testId)
            ->update([
                'is_released' => 1,
                'pass_point' => $request->pass_point,
            ]);
        return response()->json($releaseTest);
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $delete_action = DB::table('tm_test AS a')
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
        $recover_action = DB::table('tm_test AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($recover_action > 0) {
            return $recover_action;
        } else {
            return 'failed to recover';
        }
    }

    public function getTestDetail($testId)
    {
        $testDetail = DB::table('tm_test as a')
            ->select(
                'a.id',
                'a.test_name',
                'a.test_desc',
                'a.estimated_time',
                'a.pass_point',
                'a.is_released',
                DB::raw('COUNT(c.id) AS question_count'),
                DB::raw('GROUP_CONCAT(c.question SEPARATOR "|") AS questions'),
                DB::raw('GROUP_CONCAT(c.points SEPARATOR "|") AS points'),
                DB::raw('SUM(c.points) AS max_point'),
                DB::raw('GROUP_CONCAT(d.answer SEPARATOR "|") AS correct_answers')
            )
            ->leftJoin('test_has_questions as b', 'b.test_id', '=', 'a.id')
            ->leftJoin('tm_question_bank as c', function ($join) {
                $join->on('c.id', '=', 'b.question_id')
                    ->where('c.is_active', '=', 1);
            })
            ->leftJoin('tm_answer_bank as d', function ($join) {
                $join->on('d.question_id', '=', 'c.id')
                    ->where('d.correct_status', '=', 1);
            })
            ->where('a.id', $testId)
            ->groupBy('a.id')
            ->get();

        return $testDetail;
    }
}
