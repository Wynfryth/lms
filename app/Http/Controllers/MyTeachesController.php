<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyTeachesController extends Controller
{
    public function index($myteaches_kywd = null)
    {
        $nip = Auth::user()->nip;
        $myteaches = DB::table('t_class_session AS a')
            ->select('a.id', 'a.session_name', 'c.class_title', 'a.start_effective_date', 'a.end_effective_date')
            ->selectRaw(DB::raw('COUNT(d.class_session_id) AS jumlah_peserta, GROUP_CONCAT(e.Employee_name) AS peserta, GROUP_CONCAT(k.enrollment_status) AS status_kepesertaan'))
            ->leftJoin('tm_trainer_data AS b', 'b.id', '=', 'a.trainer_id')
            ->leftJoin('t_class_header AS c', 'c.id', '=', 'a.class_id')
            ->leftJoin('tr_enrollment AS d', 'd.class_session_id', '=', 'a.id')
            ->leftJoin('miegacoa_employees.emp_employee AS e', 'e.nip', '=', 'd.emp_nip')
            ->leftJoin('tm_enrollment_status AS k', 'k.id', '=', 'd.enrollment_status_id')
            ->where('b.nip', $nip)
            ->groupBy('a.id')
            ->orderBy('a.id', 'desc');
        if ($myteaches_kywd != null) {
            $any_params = [
                'a.session_name',
                // 'c.class_title',
            ];
            $myteaches->whereAny($any_params, 'like', '%' . $myteaches_kywd . '%');
        }
        $myteaches = $myteaches->paginate(10);
        return view('myteaches.index', compact('myteaches', 'myteaches_kywd'));
    }

    public function startClassSession(Request $request)
    {
        $class_session = DB::table('t_class_session AS a')
            ->where('a.id', $request->class_session_id)
            ->first();
        if ($class_session->start_effective_date > date('Y-m-d H:i:s')) {
            return response()->json(['status' => 'error', 'message' => 'Sesi kelas belum bisa dimulai.']);
        } else if ($class_session->end_effective_date < date('Y-m-d H:i:s')) {
            return response()->json(['status' => 'error', 'message' => 'Sesi kelas sudah selesai.']);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Sesi kelas dimulai.']);
        }
    }
}
