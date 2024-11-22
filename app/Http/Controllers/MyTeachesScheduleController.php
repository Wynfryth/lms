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
            ->join('tm_trainer_data AS b', 'b.id', '=', 'a.trainer_id')
            ->leftJoin('miegacoa_employees.emp_employee AS c', 'c.nip', '=', 'b.nip')
            ->where('b.nip', Auth::user()->nip)
            ->get();
        return view('myteachesschedule.index', compact('events'));
    }
}
