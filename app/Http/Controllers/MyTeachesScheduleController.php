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
            ->select('a.id', 'b.nip', 'a.session_name', 'a.start_effective_date', 'a.end_effective_date', 'c.Employee_name')
            ->selectRaw(DB::raw('COUNT(d.emp_nip) AS jumlah_peserta'))
            ->join('tm_trainer_data AS b', 'b.id', '=', 'a.trainer_id')
            ->leftJoin('miegacoa_employees.emp_employee AS c', 'c.nip', '=', 'b.nip')
            ->leftJoin('tr_enrollment AS d', 'd.class_session_id', '=', 'a.id')
            ->where('b.nip', Auth::user()->nip)
            ->groupBy('a.id')
            ->get();
        return view('myteachesschedule.index', compact('events'));
    }
}
