<?php

namespace App\Http\Controllers;

use App\Models\Enrollments;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParticipantsController extends Controller
{
    public function index($participants_kywd = null)
    {
        $sum_when = "SUM(CASE WHEN d.enrollment_status = 'REGISTERED' THEN 1 ELSE 0 END) AS registered,
                        SUM(CASE WHEN d.enrollment_status = 'ON GOING' THEN 1 ELSE 0 END) AS ongoing,
                        SUM(CASE WHEN d.enrollment_status = 'PASSED' THEN 1 ELSE 0 END) AS passed,
                        SUM(CASE WHEN d.enrollment_status = 'FAILED' THEN 1 ELSE 0 END) AS failed,
                        SUM(CASE WHEN d.enrollment_status = 'CANCELLED' THEN 1 ELSE 0 END) AS cancelled";
        $participants = DB::table('tr_enrollment AS a')
            ->select('a.emp_nip', 'c.Employee_name', 'c.Organization', 'c.Position_Nama', 'c.Branch_Name')
            ->selectRaw(DB::raw('GROUP_CONCAT(a.class_session_id) AS id_kelas, GROUP_CONCAT(b.session_name) AS nama_kelas, COUNT(emp_nip) AS jumlah_kelas, GROUP_CONCAT(d.enrollment_status) AS status_peserta'))
            ->selectRaw(DB::raw($sum_when))
            ->leftJoin('t_class_session AS b', 'b.id', '=', 'a.class_session_id')
            ->leftJoin('miegacoa_employees.emp_employee AS c', 'c.nip', '=', 'a.emp_nip')
            ->leftJoin('tm_enrollment_status AS d', 'd.id', '=', 'a.enrollment_status_id')
            ->orderBy('a.emp_nip', 'asc')
            ->groupBy('a.emp_nip');
        if ($participants_kywd != null) {
            $any_params = [
                'a.emp_nip',
                'c.Employee_name',
                'c.Organization',
                'c.Position_Nama',
                'c.Branch_Name'
            ];
            $participants->whereAny($any_params, 'like', '%' . $participants_kywd . '%');
        }
        $participants = $participants->paginate(10);
        return view('participants.index', compact('participants', 'participants_kywd'));
    }

    public function create()
    {
        $class_sessions = DB::table('t_class_session AS a')
            ->where('a.is_active', 1)
            ->get();
        return view('participants.create', compact('class_sessions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'sesi_kelas' => 'required'
            ],
            [
                'sesi_kelas.required' => 'Nama kelas belum terisi.'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        if (count($request->peserta) > 0) {
            foreach ($request->peserta as $item) {
                $enrollment = Enrollments::where(['emp_nip' => $item, 'class_session_id' => $request->sesi_kelas])->withTrashed()->first();
                if (is_null($enrollment)) {
                    $insert_enrollment_data = [
                        'emp_nip' => $item,
                        'class_session_id' => $request->sesi_kelas,
                        'enrollment_date' => Carbon::now(),
                        'enrollment_status_id' => 1, // 1 is registered
                        'created_by' => Auth::id(),
                        'created_date' => Carbon::now()
                    ];
                    $insert_enrollment = DB::table('tr_enrollment')
                        ->insertGetId($insert_enrollment_data);
                } else {
                    $insert_enrollment = 1;
                }
            }
        }
        if ($insert_enrollment > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('participants')->with($status);
        }
    }

    public function edit($id)
    {
        // $participant = DB::table('tr_enrollment AS a')
    }
}
