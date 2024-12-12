<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($classes_kywd = null)
    {
        $classes = DB::table('t_class_header AS a')
            ->select('a.id', 'a.class_title', 'a.start_eff_date', 'a.end_eff_date', 'a.class_desc', 'b.class_category', 'a.is_active')
            ->selectRaw(DB::raw('GROUP_CONCAT(d.study_material_title) AS studies, GROUP_CONCAT(d.id) AS id_studies, COUNT(d.study_material_title) AS jumlah_materi, GROUP_CONCAT(e.test_name) AS tests, GROUP_CONCAT(e.id) AS id_tests, COUNT(e.test_name) AS jumlah_tes'))
            ->leftJoin('tm_class_category AS b', 'a.class_category_id', '=', 'b.id')
            ->leftJoin('class_has_materials AS c', 'c.id_class_header', '=', 'a.id')
            ->leftJoin('tm_study_material_header AS d', 'd.id', '=', 'c.id_material')
            ->leftJoin('tm_test AS e', 'e.id', '=', 'c.id_material')
            ->groupBy('a.id')
            ->orderByDesc('a.id');
        if ($classes_kywd != null) {
            $any_params = [
                'a.class_title',
                'a.class_desc',
                'b.class_category'
            ];
            $classes->whereAny($any_params, 'like', '%' . $classes_kywd . '%');
        }
        $classes = $classes->paginate(10);
        return view('classes.index', compact('classes', 'classes_kywd'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = DB::table('tm_class_category AS a')
            ->select('a.id', 'b.category_type', 'a.class_category')
            ->leftJoin('tm_class_category_type AS b', 'b.id', '=', 'a.class_category_type_id')
            ->where('a.is_active', 1)
            ->orderBy('a.id', 'asc')
            ->get();
        return view('classes.create', compact('kategori'));
    }

    public function studies_selectpicker(Request $request)
    {
        $keyword = $request->term['term'];
        $studies = DB::table('tm_study_material_header AS a')
            ->select('a.id', 'a.study_material_title')
            ->selectRaw(DB::raw('IF(GROUP_CONCAT(d.id) IS NOT NULL, GROUP_CONCAT(d.id), "-") AS pretest_postest, "Materi" AS tipe'))
            ->leftJoin('t_test_with_materials_list AS b', 'b.study_materials_id', '=', 'a.id')
            ->leftJoin('tm_test AS c', 'c.id', '=', 'b.test_id')
            ->leftJoin('tm_test_category AS d', 'd.id', '=', 'c.test_cat_id')
            ->where([
                ['a.is_active', '=', 1],
                ['a.study_material_title', 'like', '%' . $keyword . '%']
            ])
            ->groupBy('a.id')
            ->get();
        return $studies;
    }

    public function all_studies()
    {
        $studies = DB::table('tm_study_material_header AS a')
            ->select('a.id', 'a.study_material_title')
            ->selectRaw(DB::raw('IF(GROUP_CONCAT(d.id) IS NOT NULL, GROUP_CONCAT(d.id), "-") AS pretest_postest, "Materi" AS tipe'))
            ->leftJoin('t_test_with_materials_list AS b', 'b.study_materials_id', '=', 'a.id')
            ->leftJoin('tm_test AS c', 'c.id', '=', 'b.test_id')
            ->leftJoin('tm_test_category AS d', 'd.id', '=', 'c.test_cat_id')
            ->where('a.is_active', 1)
            ->groupBy('a.id')
            ->havingRaw('(GROUP_CONCAT(d.id) = ? OR GROUP_CONCAT(d.id) = ?)', ["2,3", "3,2"])
            // ->toSql();
            ->get();
        return $studies;
    }

    public function all_trainers()
    {
        $trainers = DB::table('tm_trainer_data AS a')
            ->select('a.id', 'a.nip', 'b.Employee_name')
            ->leftJoin('miegacoa_employees.emp_employee AS b', 'b.nip', '=', 'a.nip')
            ->where('a.is_active', 1)
            ->get();
        return $trainers;
    }

    function check_studies(Request $request)
    {
        $study_category = DB::table('tm_study_material_header AS a')
            ->leftJoin('t_test_with_materials_list AS b', 'b.study_materials_id', '=', 'a.id')
            ->leftJoin('tm_test AS c', 'c.id', '=', 'b.test_id')
            ->leftJoin('tm_test_category AS d', 'd.id', '=', 'c.test_cat_id')
            ->where('a.id', $request->id_studies)
            ->get();
        return $study_category;
    }

    public function pretests_selectpicker(Request $request)
    {
        $keyword = $request->term['term'];
        $tests = DB::table('tm_test AS a')
            ->select('a.id', 'a.test_name')
            ->selectRaw('"Tes" AS tipe, COUNT(b.question_id) AS jumlah_soal')
            ->leftJoin('test_has_questions AS b', 'b.test_id', '=', 'a.id')
            ->where([
                ['a.is_active', '=', 1],
                ['a.test_cat_id', '=', 1],
                ['a.test_name', 'like', '%' . $keyword . '%']
            ])
            ->groupBy('a.id')
            ->get();
        return $tests;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kelas' => 'required',
                'kategori_kelas' => 'required',
                'class_start' => 'required',
                'class_end' => 'required',
            ],
            [
                'nama_kelas.required' => 'Nama kelas belum terisi.',
                'kategori_kelas.required' => 'Kategori kelas belum terisi.',
                'class_start.required' => 'Batas mulai belum terisi.',
                'class_end.required' => 'Batas sampai belum terisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $insert_data = [
            'class_title' => $request->nama_kelas,
            'class_desc' => $request->deskripsi_kelas,
            'class_category_id' => $request->kategori_kelas,
            'start_eff_date' => date('Y-m-d', strtotime($request->class_start)),
            'end_eff_date' => date('Y-m-d', strtotime($request->class_end)),
            'is_active' => 1,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('t_class_header')
            ->insertGetId($insert_data);
        // masukkan materi ke dalam kelas
        // if (count($request->materials) > 0) {
        //     foreach ($request->materials as $index => $item) {
        //         switch ($request->material_types[$index]) {
        //             case "Materi":
        //                 $material_type = 1;
        //                 break;
        //             case "Tes":
        //                 $material_type = 2;
        //                 break;
        //         }
        //         $insert_class_has_materials_data = [
        //             'id_class_header' => $insert_action,
        //             'id_material' => $item,
        //             'material_type' => $material_type,
        //             'material_order' => $index + 1,
        //         ];
        //         $insert_class_has_materials = DB::table('class_has_materials')
        //             ->insertGetId($insert_class_has_materials_data);
        //     }
        // }
        // notifikasi ke instruktur
        // $notification_title = "Ditambahkan ke Kelas \"" . $request->nama_sesi . "\" sebagai Instruktur";
        // $notification_content = "Anda ditambahkan sebagai Instruktur ke Kelas \"" . $request->nama_sesi . "\" oleh " . Auth::user()->name . " pada " . date('d-m-Y H:i:s');
        // $insert_notification = [
        //     'notification_title' => $notification_title,
        //     'notification_content' => $notification_content,
        //     'created_by' => Auth::id(),
        //     'created_date' => Carbon::now()
        // ];
        // $notification_id = DB::table('t_notification')->insertGetId($insert_notification);
        // $trainer_data = DB::table('tm_trainer_data AS a')->where('a.id', $request->instruktur)->first();
        // $insert_notif_receipt = [
        //     'notification_id' => $notification_id,
        //     'user_nip' => $trainer_data->nip,
        //     'read_status' => 0
        // ];
        // DB::table('t_notification_receipt')->insert($insert_notif_receipt);
        if (count($request->peserta) > 0) {
            foreach ($request->peserta as $item) {
                $insert_enrollment_data = [
                    'emp_nip' => $item,
                    'class_id' => $insert_action,
                    'enrollment_date' => Carbon::now(),
                    'enrollment_status_id' => 1, // 1 is registered
                    'created_by' => Auth::id(),
                    'created_date' => Carbon::now()
                ];
                $insert_enrollment = DB::table('tr_enrollment')
                    ->insertGetId($insert_enrollment_data);
                $user = User::where(['nip' => $item])->first();
                if ($user) {
                    $user->removeRole('Guest');
                    $user->assignRole('Student');
                }
                $notification_title = "Ditambahkan ke Kelas \"" . $request->nama_kelas . "\" sebagai Peserta";
                $notification_content = "Anda ditambahkan sebagai Peserta ke Kelas \"" . $request->nama_kelas . "\" oleh " . Auth::user()->name . " pada " . date('d-m-Y H:i:s');
                $insert_notification = [
                    'notification_title' => $notification_title,
                    'notification_content' => $notification_content,
                    'created_by' => Auth::id(),
                    'created_date' => Carbon::now()
                ];
                $notification_id = DB::table('t_notification')->insertGetId($insert_notification);
                $insert_notif_receipt = [
                    'notification_id' => $notification_id,
                    'user_nip' => $item,
                    'read_status' => 0
                ];
                DB::table('t_notification_receipt')->insert($insert_notif_receipt);
            }
        }
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('class_sessions.create', $insert_action)->with($status);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $class_type = DB::table('t_class_header AS a')
            ->leftJoin('tm_class_category AS b', 'b.id', '=', 'a.class_category_id')
            ->leftJoin('tm_class_category_type AS c', 'c.id', '=', 'b.class_category_type_id')
            ->where('a.id', $id)
            ->first();
        $students = DB::table('tr_enrollment AS a')
            ->select('a.id', 'a.emp_nip', 'b.Employee_name AS student_name', 'b.Organization', 'c.enrollment_status')
            ->leftJoin('miegacoa_employees.emp_employee AS b', 'b.nip', '=', 'a.emp_nip')
            ->leftJoin('tm_enrollment_status AS c', 'c.id', '=', 'a.enrollment_status_id')
            ->where('a.class_id', $id)
            ->get();
        switch ($class_type->category_type) {
            case "Training Class":
                $item = DB::table('t_class_header AS a')
                    ->select('a.*', 'e.category_type')
                    ->selectRaw(DB::raw('GROUP_CONCAT(c.id) AS id_materials, GROUP_CONCAT(c.study_material_title) AS studies, 0 AS jumlah_soal'))
                    ->leftJoin('class_has_materials AS b', 'b.id_class_header', '=', 'a.id')
                    ->leftJoin('tm_study_material_header AS c', 'c.id', '=', 'b.id_material')
                    ->leftJoin('tm_class_category AS d', 'd.id', '=', 'a.class_category_id')
                    ->leftJoin('tm_class_category_type AS e', 'e.id', '=', 'd.class_category_type_id')
                    ->where('a.id', $id)
                    ->groupBy('a.id')
                    ->first();
                break;
            case "Pre-test Class":
                $item = DB::table('t_class_header AS a')
                    ->select('a.*', 'e.category_type')
                    ->selectRaw(DB::raw('GROUP_CONCAT(c.id) AS id_materials, GROUP_CONCAT(c.test_name) AS studies, GROUP_CONCAT(f.jumlah_soal) AS jumlah_soal'))
                    ->leftJoin('class_has_materials AS b', 'b.id_class_header', '=', 'a.id')
                    ->leftJoin('tm_test AS c', 'c.id', '=', 'b.id_material')
                    ->leftJoin('tm_class_category AS d', 'd.id', '=', 'a.class_category_id')
                    ->leftJoin('tm_class_category_type AS e', 'e.id', '=', 'd.class_category_type_id')
                    ->leftJoin(DB::raw('(SELECT a.id, COUNT(b.question_id) AS jumlah_soal
                                        FROM tm_test AS a
                                        LEFT JOIN test_has_questions AS b ON b.test_id = a.id
                                        GROUP BY a.id
                                    ) AS f'), 'f.id', '=', 'c.id')
                    ->leftJoin('test_has_questions AS f', 'f.test_id', '=', 'a.id')
                    ->where('a.id', $id)
                    ->groupBy('a.id')
                    ->first();
                break;
        }
        $kategori = DB::table('tm_class_category AS a')
            ->select('a.id', 'a.class_category', 'b.category_type')
            ->leftJoin('tm_class_category_type AS b', 'b.id', '=', 'a.class_category_type_id')
            ->where('a.is_active', 1)
            ->orderBy('a.id', 'asc')
            ->get();
        return view('classes.edit', compact('item', 'kategori', 'students'));
    }

    public function cancel_student(Request $request)
    {
        $cancel_id = 5; // cancel id in cancel status master
        $cancel_action = DB::table('tr_enrollment AS a')
            ->where([
                'class_id' => $request->class_id,
                'emp_nip' => $request->student_nip,
            ])
            ->update([
                'enrollment_status_id' => $cancel_id,
            ]);
        return $cancel_action;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kelas' => 'required',
                'kategori_kelas' => 'required',
            ],
            [
                'nama_kelas.required' => 'Nama kelas belum terisi.',
                'kategori_kelas.required' => 'Kategori kelas belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $update_data = [
            'class_title' => $request->nama_kelas,
            'class_desc' => $request->deskripsi_kelas,
            'class_category_id' => $request->kategori_kelas,
            'start_eff_date' => date('Y-m-d', strtotime($request->class_start)),
            'end_eff_date' => date('Y-m-d', strtotime($request->class_end)),
            'is_active' => 1,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_action = DB::table('t_class_header AS a')
            ->where('a.id', $id)
            ->update($update_data);
        $delete_class_has_materials = DB::table('class_has_materials')
            ->where('id_class_header', $id)
            ->delete();
        if (count($request->materials) > 0) {
            foreach ($request->materials as $index => $item) {
                switch ($request->material_types[$index]) {
                    case "Materi":
                        $material_type = 1;
                        break;
                    case "Tes":
                        $material_type = 2;
                        break;
                }
                $update_class_has_materials_data = [
                    'id_class_header' => $id,
                    'id_material' => $item,
                    'material_type' => $material_type,
                    'material_order' => $index + 1,
                ];
                $update_class_has_materials = DB::table('class_has_materials')
                    ->insertGetId($update_class_has_materials_data);
            }
        }
        if ($update_action > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengubah data!'
            ];
            return redirect()->route('classes')->with($status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classes $classes)
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
        $delete_action = DB::table('t_class_header AS a')
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
        $recover_action = DB::table('t_class_header AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($recover_action > 0) {
            return $recover_action;
        } else {
            return 'failed to recover';
        }
    }
}
