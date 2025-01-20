<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyTeachesScheduleController extends Controller
{
    public function index($myteachesschedule_kywd = null)
    {
        $events = DB::table('t_class_session AS a')
            ->select('a.id', 'b.nip', 'a.session_name', 'a.start_effective_date', 'a.end_effective_date', 'c.Employee_name', 'a.is_active')
            ->selectRaw(DB::raw('COUNT(d.emp_nip) AS jumlah_peserta'))
            ->join('tm_trainer_data AS b', 'b.id', '=', 'a.trainer_id')
            ->leftJoin('miegacoa_employees.emp_employee AS c', 'c.nip', '=', 'b.nip')
            ->leftJoin('t_class_header AS e', 'e.id', '=', 'a.class_id')
            ->leftJoin('tr_enrollment AS d', 'd.class_id', '=', 'e.id')
            ->where('b.nip', Auth::user()->nip)
            ->groupBy('a.id')
            ->get();
        return view('myteachesschedule.index', compact('events'));
    }
}
