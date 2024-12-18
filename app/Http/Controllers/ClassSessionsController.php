<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class ClassSessionsController extends Controller
{
    public function index($class_sessions_kywd = null)
    {
        $class_sessions = DB::table('t_class_session AS a')
            ->leftJoin('t_class_header AS b', 'a.class_id', '=', 'b.id')
            ->leftJoin('tm_trainer_data AS c', 'c.id', '=', 'a.trainer_id')
            ->leftJoin('tm_location_type AS d', 'd.id', '=', 'a.loc_type_id')
            ->leftJoin('tm_training_center AS e', 'e.id', '=', 'a.tc_id')
            ->leftJoin('miegacoa_employees.emp_employee AS f', 'f.nip', '=', 'c.nip')
            ->leftJoin('tm_class_category AS g', 'g.id', '=', 'b.class_category_id')
            ->leftJoin('tr_enrollment AS h', 'h.class_session_id', '=', 'a.id')
            ->leftJoin('miegacoa_employees.emp_employee AS i', 'i.nip', '=', 'h.emp_nip')
            ->leftJoin('tm_enrollment_status AS j', 'j.id', '=', 'h.enrollment_status_id')
            ->select('a.id', 'a.session_name', 'a.desc', 'b.class_title', 'g.class_category', 'f.Employee_name', 'd.location_type', 'e.tc_name', 'a.start_effective_date', 'a.end_effective_date', 'a.is_active')
            ->selectRaw(DB::raw('COUNT(h.id) AS jumlah_peserta, GROUP_CONCAT(i.Employee_name) AS participants, GROUP_CONCAT(j.enrollment_status) AS status_kepesertaan'))
            ->orderByDesc('a.id')
            ->groupBy('a.id');
        if ($class_sessions_kywd != null) {
            $any_params = [
                'b.class_title',
                'g.class_category',
                'f.Employee_name',
                'd.location_type',
                'e.tc_name',
                'a.start_effective_date',
                'a.end_effective_date',
            ];
            $class_sessions->whereAny($any_params, 'like', '%' . $class_sessions_kywd . '%');
            // $class_sessions->havingRaw('participants LIKE %' . $class_sessions_kywd . '%');
        }
        $class_sessions = $class_sessions->paginate(10);

        $bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        foreach ($class_sessions as $index => $item) {
            // $month_number = intval(explode('-', $class_sessions[$index]->class_period)[1]) - 1;
            $class_sessions[$index]->start_effective_date = date('d-m-Y', strtotime($class_sessions[$index]->start_effective_date));
            $class_sessions[$index]->end_effective_date = date('d-m-Y', strtotime($class_sessions[$index]->end_effective_date));
        }
        return view('class_sessions.index', compact('class_sessions', 'class_sessions_kywd'));
    }

    public function create($class_id)
    {
        $class = DB::table('t_class_header AS a')
            ->select('a.id', 'a.class_title', 'b.class_category_type_id', 'b.class_category', 'a.start_eff_date', 'a.end_eff_date')
            ->selectRaw(DB::raw('COUNT(c.id) AS jumlah_peserta'))
            ->leftJoin('tm_class_category AS b', 'b.id', '=', 'a.class_category_id')
            ->leftJoin('tr_enrollment AS c', 'c.class_id', '=', 'a.id')
            ->where(['a.is_active' => 1, 'a.id' => $class_id])
            ->groupBy('a.id')
            ->first();
        $class_session_schedules = DB::table('t_class_session AS a')
            ->select(
                'a.id',
                'a.session_name',
                'a.desc',
                'a.class_id',
                'a.session_order',
                'b.id AS schedule_id',
                'b.start_eff_date',
                'b.end_eff_date',
                'f.Employee_name AS trainer',
                'g.location_type',
                'c.study_material_title',
                'd.test_name'
            )
            ->selectRaw(DB::raw('(SELECT COUNT(*) FROM t_session_material_schedule WHERE class_session_id = a.id) AS session_schedule_count'))
            ->leftJoin('t_session_material_schedule AS b', 'b.class_session_id', '=', 'a.id')
            ->leftJoin('tm_study_material_header AS c', function ($join) {
                $join->on('c.id', '=', 'b.material_id')
                    ->where('b.material_type', '=', 1);
            })
            ->leftJoin('tm_test AS d', function ($join) {
                $join->on('d.id', '=', 'b.material_id')
                    ->where('b.material_type', '=', 2);
            })
            ->leftJoin('tm_trainer_data AS e', 'e.id', '=', 'a.trainer_id')
            ->leftJoin('miegacoa_employees.emp_employee AS f', 'f.nip', '=', 'e.nip')
            ->leftJoin('tm_location_type AS g', 'g.id', '=', 'a.loc_type_id')
            ->where('a.class_id', $class_id)
            ->orderBy('a.session_order', 'asc')
            ->orderBy('b.start_eff_date', 'asc')
            ->get();
        $instructor = DB::table('tm_trainer_data AS a')
            ->select('a.id', 'b.Employee_name')
            ->leftJoin('miegacoa_employees.emp_employee AS b', 'b.nip', '=', 'a.nip')
            ->where('a.is_active', 1)
            ->get();
        $training_center = DB::table('tm_training_center AS a')
            ->where('a.is_active', 1)
            ->get();
        $loc_type = DB::table('tm_location_type AS a')
            ->where('a.is_active', 1)
            ->get();
        $class_category_type = $class->class_category_type_id;
        switch ($class_category_type) {
            case "1":
                $materials = DB::table('tm_study_material_header AS a')
                    ->select('a.id', 'a.study_material_title AS material_name', 'a.study_material_desc', 'b.study_material_category', 'a.is_active')
                    ->selectRaw('GROUP_CONCAT(e.id) AS kategori_tes, GROUP_CONCAT(d.test_name) AS tests')
                    ->leftJoin('tm_study_material_category AS b', 'b.id', '=', 'a.category_id')
                    ->leftJoin('t_test_with_materials_list AS c', 'c.study_materials_id', '=', 'a.id')
                    ->leftJoin('tm_test AS d', 'd.id', '=', 'c.test_id')
                    ->leftJoin('tm_test_category AS e', 'e.id', '=', 'd.test_cat_id')
                    ->groupBy('a.id')
                    // ->having('(GROUP_CONCAT(e.id) = "3,2" OR GROUP_CONCAT(e.id) = "2,3")')
                    ->havingRaw('(GROUP_CONCAT(e.id) = ? OR GROUP_CONCAT(e.id) = ?)', ["2,3", "3,2"])
                    ->orderByDesc('a.id')
                    ->get();
                break;
            case "2":
                $materials = DB::table('tm_test AS a')
                    ->leftJoin('tm_test_category AS b', 'b.id', '=', 'a.test_cat_id')
                    ->select('a.id', 'a.test_name AS material_name')
                    ->where('a.test_cat_id', 1)
                    ->get();
                break;
        }
        return view('class_sessions.create', compact('class_id', 'class_session_schedules', 'class_category_type', 'class', 'instructor', 'training_center', 'loc_type', 'materials'));
    }

    public function participant_selectpicker(Request $request)
    {
        $keyword = $request->term['term'];
        $participants = DB::table('miegacoa_employees.emp_employee AS a')
            ->select('a.nip', 'a.Employee_name', 'a.Organization')
            ->where('a.Employee_name', 'like', '%' . $keyword . '%')
            ->get();
        return $participants;
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_sesi' => 'required',
                // 'kelas' => 'required',/
                'session_start_date' => 'required',
                'session_start_time' => 'required',
                'instruktur' => 'required',
                'training_center' => 'required',
                'loc_type' => 'required',
                // 'deskripsi_sesi' => 'required',
                // 'peserta' => 'array|required',
            ],
            [
                'nama_sesi.required' => 'Nama sesi belum terisi.',
                // 'kelas.required' => 'Kelas belum terisi.',
                'session_start_date.required' => 'Tanggal mulai sesi belum terisi.',
                'session_start_time.required' => 'Waktu mulai sesi belum terisi.',
                'instruktur.required' => 'Instruktur belum terisi.',
                'training_center.required' => 'Training Center belum terisi.',
                'loc_type.required' => 'Tipe pembelajaran belum terisi.',
                // 'deskripsi_sesi.required' => 'Deskripsi sesi belum terisi.',
                // 'peserta.required' => 'Peserta belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $latest_order = DB::table('t_class_session AS a')
            ->selectraw('IF(MAX(a.session_order) IS NOT NULL, MAX(a.session_order), 0) AS last_order')
            ->where('class_id', $request->class_id)
            ->first();
        $insert_data = [
            'session_name' => $request->nama_sesi,
            'desc' => $request->deskripsi_sesi,
            'class_id' => $request->class_id,
            'start_effective_date' => date('Y-m-d H:i:s', strtotime($request->session_start_date . ' ' . $request->session_start_time)),
            'session_order' => $latest_order->last_order + 1,
            'is_active' => 1,
            'trainer_id' => $request->instruktur,
            'loc_type_id' => $request->loc_type,
            'tc_id' => $request->training_center,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('t_class_session')
            ->insertGetId($insert_data);

        // INSERTING TO MATERIAL SCHEDULE INSIDE CLASS SESSION
        switch ($request->class_category_type) { // checking if its pre-class or training class
            case "1": // training class
                if ($request->materi != null) {
                    $session_start_datetime = date('Y-m-d H:i:s', strtotime($request->session_start_date . ' ' . $request->session_start_time));
                    foreach ($request->materi as $material) {
                        // $session_start_datetime = date('Y-m-d H:i:s', strtotime($request->session_start_date . ' ' . $request->session_start_time));

                        // SEARCHING FOR THE LATEST MATERIAL ORDER FROM THE CLASS SESSION
                        $latest_order = DB::table('t_session_material_schedule AS a')
                            ->selectRaw('IF(MAX(a.material_order) IS NOT NULL, MAX(a.material_order), 0) AS last_order')
                            ->where('class_session_id', $insert_action)
                            ->first();

                        // INSERTING PRE-TEST
                        $pretest = DB::table('t_test_with_materials_list AS a')
                            ->select('a.test_id', 'b.estimated_time')
                            ->leftJoin('tm_test As b', 'b.id', '=', 'a.test_id')
                            ->where(['a.study_materials_id' => $material, 'b.test_cat_id' => 2])
                            ->first();
                        $insert_pretest_data = [
                            'class_session_id' => $insert_action,
                            'material_id' => $pretest->test_id,
                            'material_type' => 2,
                            'material_order' => $latest_order->last_order + 1,
                            'start_eff_date' => $session_start_datetime,
                            'end_eff_date' => DB::raw("ADDTIME('$session_start_datetime', '$pretest->estimated_time')"),
                            'created_by' => Auth::id(),
                            'created_date' => Carbon::now()
                        ];
                        $insert_pretest = DB::table('t_session_material_schedule')
                            ->insertGetId($insert_pretest_data);

                        // INSERTING STUDY
                        $pretest_schedule = DB::table('t_session_material_schedule AS a')
                            ->select('a.end_eff_date')
                            ->where('a.id', $insert_pretest)
                            ->first();
                        $study_duration = DB::table('tm_study_material_header AS a')
                            ->select('a.id')
                            ->selectRaw('GROUP_CONCAT(b.name) AS pembelajaran, GROUP_CONCAT(c.filename) AS attachments, SEC_TO_TIME( SUM( TIME_TO_SEC(c.estimated_time) ) ) AS total_waktu')
                            ->leftJoin('tm_study_material_detail AS b', 'b.header_id', '=', 'a.id')
                            ->leftJoin('tm_study_material_attachments AS c', 'c.study_material_detail_id', '=', 'b.id')
                            ->where('a.id', $material)
                            ->groupBy('a.id')
                            ->first();
                        $insert_study_data = [
                            'class_session_id' => $insert_action,
                            'material_id' => $material,
                            'material_type' => 1,
                            'material_order' => $latest_order->last_order + 2,
                            'start_eff_date' => $pretest_schedule->end_eff_date,
                            'end_eff_date' => DB::raw("ADDTIME('$pretest_schedule->end_eff_date', '$study_duration->total_waktu')"),
                            'created_by' => Auth::id(),
                            'created_date' => Carbon::now()
                        ];
                        $insert_study = DB::table('t_session_material_schedule')
                            ->insertGetId($insert_study_data);

                        // INSERTING POST-TEST
                        $study_schedule = DB::table('t_session_material_schedule AS a')
                            ->select('a.end_eff_date')
                            ->where('a.id', $insert_study)
                            ->first();
                        $posttest = DB::table('t_test_with_materials_list AS a')
                            ->select('a.test_id', 'b.estimated_time')
                            ->leftJoin('tm_test As b', 'b.id', '=', 'a.test_id')
                            ->where(['a.study_materials_id' => $material, 'b.test_cat_id' => 3])
                            ->first();
                        $insert_posttest_data = [
                            'class_session_id' => $insert_action,
                            'material_id' => $posttest->test_id,
                            'material_type' => 2,
                            'material_order' => $latest_order->last_order + 3,
                            'start_eff_date' => $study_schedule->end_eff_date,
                            'end_eff_date' => DB::raw("ADDTIME('$study_schedule->end_eff_date', '$posttest->estimated_time')"),
                            'created_by' => Auth::id(),
                            'created_date' => Carbon::now()
                        ];
                        $insert_posttest = DB::table('t_session_material_schedule')
                            ->insertGetId($insert_posttest_data);
                        // GETTING THE LATEST END DATE FOR UPDATING THE CLASS SESSION END DATE TIME
                        $session_end_datetime_query = DB::table('t_session_material_schedule AS a')
                            ->select('a.end_eff_date')
                            ->where('a.id', $insert_posttest)
                            ->first();
                        $session_start_datetime = $session_end_datetime_query->end_eff_date;
                    }
                    $update_class_session_end_datetime = DB::table('t_class_session AS a')
                        ->where('a.id', $insert_action)
                        ->update(['end_effective_date' => $session_end_datetime_query->end_eff_date]);
                }
                break;
            case "2": //  pre-class

                break;
            default:
                break;
        }

        // TRAINER'S NOTIFICATON
        $class = DB::table('t_class_header')->select('class_title')->where('id', $request->class_id)->first();
        $class_title = $class->class_title;
        $notification_title = "Ditambahkan ke Kelas \"" . $class_title . "\" (Sesi Kelas \"" . $request->nama_sesi . "\") sebagai Instruktur";
        $notification_content = "Anda ditambahkan sebagai Instruktur ke Kelas \"" . $class_title . "\" (Sesi Kelas \"" . $request->nama_sesi . "\") oleh " . Auth::user()->name . " pada " . date('d-m-Y H:i:s');
        $insert_notification = [
            'notification_title' => $notification_title,
            'notification_content' => $notification_content,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $notification_id = DB::table('t_notification')->insertGetId($insert_notification);
        $trainer_data = DB::table('tm_trainer_data AS a')->where('a.id', $request->instruktur)->first();
        $insert_notif_receipt = [
            'notification_id' => $notification_id,
            'user_nip' => $trainer_data->nip,
            'read_status' => 0
        ];
        DB::table('t_notification_receipt')->insert($insert_notif_receipt);

        // REDIRECTING THE PAGE IF THE INSERT IS SUCCESSFUL
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('class_sessions.create', $request->class_id)->with($status);
        }
    }

    public function edit(Request $request, $id)
    {
        $item = DB::table('t_class_session AS a')
            ->select('a.*')
            ->selectRaw(DB::raw('GROUP_CONCAT(b.emp_nip) AS nip_peserta, GROUP_CONCAT(c.Employee_name) AS peserta, GROUP_CONCAT(c.Organization) AS divisi, GROUP_CONCAT(d.enrollment_status) AS status_kepesertaan'))
            ->leftJoin('tr_enrollment AS b', 'b.class_session_id', '=', 'a.id')
            ->leftJoin('miegacoa_employees.emp_employee AS c', 'c.nip', '=', 'b.emp_nip')
            ->leftJoin('tm_enrollment_status AS d', 'd.id', '=', 'b.enrollment_status_id')
            ->where('a.id', $id)
            ->first();
        $classes = DB::table('t_class_header AS a')
            ->where('a.is_active', 1)
            ->get();
        $instructor = DB::table('tm_trainer_data AS a')
            ->select('a.id', 'b.Employee_name')
            ->leftJoin('miegacoa_employees.emp_employee AS b', 'b.nip', '=', 'a.nip')
            ->where('a.is_active', 1)
            ->get();
        $training_center = DB::table('tm_training_center AS a')
            ->where('a.is_active', 1)
            ->get();
        $loc_type = DB::table('tm_location_type AS a')
            ->where('a.is_active', 1)
            ->get();
        return view('class_sessions.edit', compact('item', 'classes', 'instructor', 'training_center', 'loc_type'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_sesi' => 'required',
                'kelas' => 'required',
                'periode_efektif_sesi_mulai' => 'required',
                'periode_efektif_sesi_sampai' => 'required',
                'instruktur' => 'required',
                'training_center' => 'required',
                'loc_type' => 'required',
                'deskripsi_sesi' => 'required',
                // 'peserta' => 'array|required',
            ],
            [
                'nama_sesi.required' => 'Nama sesi belum terisi.',
                'kelas.required' => 'Kelas belum terisi.',
                'periode_efektif_sesi_mulai.required' => 'Periode mulai belum terisi.',
                'periode_efektif_sesi_sampai.required' => 'Periode sampai belum terisi.',
                'instruktur.required' => 'Instruktur belum terisi.',
                'training_center.required' => 'Training Center belum terisi.',
                'loc_type.required' => 'Tipe pembelajaran belum terisi.',
                'deskripsi_sesi.required' => 'Deskripsi sesi belum terisi.',
                // 'peserta.required' => 'Peserta belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $update_data = [
            'session_name' => $request->nama_sesi,
            'desc' => $request->deskripsi_sesi,
            'class_id' => $request->kelas,
            'start_effective_date' => date('Y-m-d', strtotime($request->periode_efektif_sesi_mulai)),
            'end_effective_date' => date('Y-m-d', strtotime($request->periode_efektif_sesi_sampai)),
            'is_active' => 1,
            'trainer_id' => $request->instruktur,
            'loc_type_id' => $request->loc_type,
            'tc_id' => $request->training_center,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_action = DB::table('t_class_session AS a')
            ->where('a.id', $id)
            ->update($update_data);
        if (count($request->peserta) > 0) {
            foreach ($request->peserta as $item) {
                $update_enrollment_data = [
                    'emp_nip' => $item,
                    'class_session_id' => $id,
                    'enrollment_date' => Carbon::now(),
                    'enrollment_status_id' => 1, // 1 is registered
                    'created_by' => Auth::id(),
                    'created_date' => Carbon::now()
                ];
                // sebenarnya insert sih cuman karena ini update makanya namanya update action
                $update_enrollment = DB::table('tr_enrollment')
                    ->insertGetId($update_enrollment_data);
                $user = User::where(['nip' => $item])->first();
                if ($user) {
                    $user->removeRole('Guest');
                    $user->assignRole('Student');
                }
                $notification_title = "Ditambahkan ke Sesi Kelas \"" . $request->nama_sesi . "\" sebagai Peserta";
                $notification_content = "Anda ditambahkan sebagai Peserta ke Sesi Kelas \"" . $request->nama_sesi . "\" oleh " . Auth::user()->name . " pada " . date('d-m-Y H:i:s');
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
        if ($update_action > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('class_sessions')->with($status);
        }
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $delete_action = DB::table('t_class_session AS a')
            ->where('a.id', $request->id)
            ->update($delete_data);
        $class_session = DB::table('t_class_session AS a')
            ->where('a.id', $request->id)
            ->first();
        // notif trainer
        $trainer = DB::table('tm_trainer_data AS a')
            ->where('a.id', $class_session->trainer_id)
            ->first();
        $notification_title = "Sesi Kelas \"" . $class_session->session_name . "\" dibatalkan";
        $notification_content = "Sesi Kelas \"" . $class_session->session_name . "\" anda sebagai instruktur dibatalkan oleh " . Auth::user()->name . " pada " . date('d-m-Y H:i:s');
        $insert_notification = [
            'notification_title' => $notification_title,
            'notification_content' => $notification_content,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $notification_id = DB::table('t_notification')->insertGetId($insert_notification);
        $insert_notif_receipt = [
            'notification_id' => $notification_id,
            'user_nip' => $trainer->nip,
            'read_status' => 0
        ];
        DB::table('t_notification_receipt')->insert($insert_notif_receipt);
        // notif peserta
        $students = DB::table('t_enrollment AS a')
            ->where('a.class_session_id', $request->id)
            ->get();
        if ($students->isNotEmpty()) {
            foreach ($students as $student) {
                $user = User::where(['nip' => $student->emp_nip])->first();
                $notification_title = "Sesi Kelas \"" . $class_session->session_name  . "\" dibatalkan";
                $notification_content = "Sesi Kelas \"" . $class_session->session_name . "\" anda sebagai peserta dibatalkan oleh " . Auth::user()->name . " pada " . date('d-m-Y H:i:s');
                $insert_notification = [
                    'notification_title' => $notification_title,
                    'notification_content' => $notification_content,
                    'created_by' => Auth::id(),
                    'created_date' => Carbon::now()
                ];
                $notification_id = DB::table('t_notification')->insertGetId($insert_notification);
                $insert_notif_receipt = [
                    'notification_id' => $notification_id,
                    'user_nip' => $student->emp_nip,
                    'read_status' => 0
                ];
                DB::table('t_notification_receipt')->insert($insert_notif_receipt);
            }
        }
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
        $recover_action = DB::table('t_class_session AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        $class_session = DB::table('t_class_session AS a')
            ->where('a.id', $request->id)
            ->first();
        // notif trainer
        $trainer = DB::table('tm_trainer_data AS a')
            ->where('a.id', $class_session->trainer_id)
            ->first();
        $notification_title = "Sesi Kelas \"" . $class_session->session_name . "\" diberlakukan kembali";
        $notification_content = "Sesi Kelas \"" . $class_session->session_name . "\" anda sebagai instruktur diberlakukan kembali oleh " . Auth::user()->name . " pada " . date('d-m-Y H:i:s');
        $insert_notification = [
            'notification_title' => $notification_title,
            'notification_content' => $notification_content,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $notification_id = DB::table('t_notification')->insertGetId($insert_notification);
        $insert_notif_receipt = [
            'notification_id' => $notification_id,
            'user_nip' => $trainer->nip,
            'read_status' => 0
        ];
        DB::table('t_notification_receipt')->insert($insert_notif_receipt);
        // notif peserta
        $students = DB::table('t_enrollment AS a')
            ->where('a.class_session_id', $request->id)
            ->get();
        if ($students->isNotEmpty()) {
            foreach ($students as $student) {
                $user = User::where(['nip' => $student->emp_nip])->first();
                $notification_title = "Sesi Kelas \"" . $class_session->session_name  . "\" diberlakukan kembali";
                $notification_content = "Sesi Kelas \"" . $class_session->session_name . "\" anda sebagai peserta diberlakukan kembali oleh " . Auth::user()->name . " pada " . date('d-m-Y H:i:s');
                $insert_notification = [
                    'notification_title' => $notification_title,
                    'notification_content' => $notification_content,
                    'created_by' => Auth::id(),
                    'created_date' => Carbon::now()
                ];
                $notification_id = DB::table('t_notification')->insertGetId($insert_notification);
                $insert_notif_receipt = [
                    'notification_id' => $notification_id,
                    'user_nip' => $student->emp_nip,
                    'read_status' => 0
                ];
                DB::table('t_notification_receipt')->insert($insert_notif_receipt);
            }
        }
        if ($recover_action > 0) {
            return $recover_action;
        } else {
            return 'failed to recover';
        }
    }

    public function cancel_student(Request $request)
    {
        $nip = $request->nip;
        $class_session_id = $request->class_session_id;
        $where_params = [
            'emp_nip' => $nip,
            'class_session_id' => $class_session_id
        ];
        $update_data = [
            'enrollment_status_id' => 5 // id cancelled
        ];
        $cancel_action = DB::table('tr_enrollment')->where($where_params)->update($update_data);
        // notify the student
        $class_session = DB::table('t_class_session AS a')->where('a.id', $class_session_id)->first();
        $notification_title = "Kepesertaan anda dibatalkan di Sesi Kelas \"" . $class_session->session_name  . "\"";
        $notification_content = "Sesi Kelas \"" . $class_session->session_name . "\" anda sebagai peserta dibatalkan oleh " . Auth::user()->name . " pada " . date('d-m-Y H:i:s');
        $insert_notification = [
            'notification_title' => $notification_title,
            'notification_content' => $notification_content,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $notification_id = DB::table('t_notification')->insertGetId($insert_notification);
        $insert_notif_receipt = [
            'notification_id' => $notification_id,
            'user_nip' => $nip,
            'read_status' => 0
        ];
        DB::table('t_notification_receipt')->insert($insert_notif_receipt);
        return $cancel_action;
    }

    public function deleteSchedule(Request $request)
    {
        $delete_action = DB::table('t_session_material_schedule AS a')
            ->where('a.id', $request->scheduleId)
            ->delete();
        return $delete_action;
    }

    public function getScheduleDetail($scheduleId)
    {
        $schedule = DB::table('t_session_material_schedule AS a')
            ->select(
                'a.id AS scheduleId',
                'a.class_session_id',
                'a.material_type',
                'a.start_eff_date',
                'a.end_eff_date',
                'b.id AS studyId',
                'b.study_material_title',
                'b.study_material_desc',
                'b.study_estimated_time',
                'c.id AS testId',
                'c.test_name',
                'c.test_desc',
                'c.estimated_time AS test_estimated_time'
            )
            ->leftJoin(DB::raw('(SELECT
                a.id, a.study_material_title, a.study_material_desc, SEC_TO_TIME(SUM(TIME_TO_SEC(c.estimated_time))) AS study_estimated_time
                FROM tm_study_material_header AS a
                LEFT JOIN tm_study_material_detail AS b ON b.header_id = a.id
                LEFT JOIN tm_study_material_attachments AS c ON c.study_material_detail_id = b.id
                GROUP BY a.id
                ) AS b'), function ($join) {
                $join->on('b.id', '=', 'a.material_id')
                    ->where('a.material_type', '=', 1);
            })
            ->leftJoin('tm_test AS c', function ($join) {
                $join->on('c.id', '=', 'a.material_id')
                    ->where('a.material_type', '=', 2);
            })
            ->where('a.id', $scheduleId)
            ->first();
        return view('class_sessions.editSchedule', compact('schedule', 'scheduleId'));
    }

    public function updateSchedule(Request $request)
    {
        $scheduleId = $request->schedule_id;
        $updateSchedule_data = [
            'start_eff_date' => date('Y-m-d H:i:s', strtotime($request->start_date . ' ' . $request->start_time)),
            'end_eff_date' => date('Y-m-d H:i:s', strtotime($request->end_date . ' ' . $request->end_time)),
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $updateSchedule = DB::table('t_session_material_schedule')
            ->where('id', $scheduleId)
            ->update($updateSchedule_data);
        if ($updateSchedule > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengedit sesi!'
            ];
            return redirect()->back()->with($status);
        }
    }
}
