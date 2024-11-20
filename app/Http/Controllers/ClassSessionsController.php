<?php

namespace App\Http\Controllers;

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
            ->select('a.id', 'a.session_name', 'a.desc', 'b.class_title', 'g.class_category', 'f.Employee_name', 'd.location_type', 'e.tc_name', 'a.start_effective_date', 'a.end_effective_date', 'a.is_active')
            ->selectRaw(DB::raw('COUNT(h.id) AS jumlah_peserta, GROUP_CONCAT(i.Employee_name) AS participants'))
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

    public function create()
    {
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
        return view('class_sessions.create', compact('classes', 'instructor', 'training_center', 'loc_type'));
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
        $insert_data = [
            'session_name' => $request->nama_sesi,
            'desc' => $request->deskripsi_sesi,
            'class_id' => $request->kelas,
            'start_effective_date' => date('Y-m-d', strtotime($request->periode_efektif_sesi_mulai)),
            'end_effective_date' => date('Y-m-d', strtotime($request->periode_efektif_sesi_sampai)),
            'is_active' => 1,
            'trainer_id' => $request->instruktur,
            'loc_type_id' => $request->loc_type,
            'tc_id' => $request->training_center,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('t_class_session')
            ->insertGetId($insert_data);
        if (count($request->peserta) > 0) {
            foreach ($request->peserta as $item) {
                $insert_enrollment_data = [
                    'emp_nip' => $item,
                    'class_session_id' => $insert_action,
                    'enrollment_date' => Carbon::now(),
                    'enrollment_status_id' => 1, // 1 is registered
                    'created_by' => Auth::id(),
                    'created_date' => Carbon::now()
                ];
                $insert_enrollment = DB::table('tr_enrollment')
                    ->insertGetId($insert_enrollment_data);
            }
        }
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('class_sessions')->with($status);
        }
    }

    public function edit(Request $request, $id)
    {
        $item = DB::table('t_class_session AS a')
            ->select('a.*')
            ->selectRaw(DB::raw('GROUP_CONCAT(b.emp_nip) AS nip_peserta, GROUP_CONCAT(c.Employee_name) AS peserta'))
            ->leftJoin('tr_enrollment AS b', 'b.class_session_id', '=', 'a.id')
            ->leftJoin('miegacoa_employees.emp_employee AS c', 'c.nip', '=', 'b.emp_nip')
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
        $delete_enrollment = DB::table('tr_enrollment')
            ->where('class_session_id', $id)
            ->delete();
        if (count($request->peserta) > 0) {
            foreach ($request->peserta as $item) {
                $update_enrollment_data = [
                    'emp_nip' => $item,
                    'class_session_id' => $id,
                    'enrollment_date' => Carbon::now(),
                    'enrollment_status_id' => 1, // 1 is registered
                    'modified_by' => Auth::id(),
                    'modified_date' => Carbon::now()
                ];
                $update_enrollment = DB::table('tr_enrollment')
                    ->insertGetId($update_enrollment_data);
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
        if ($recover_action > 0) {
            return $recover_action;
        } else {
            return 'failed to recover';
        }
    }
}
