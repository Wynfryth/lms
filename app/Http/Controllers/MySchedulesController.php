<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MySchedulesController extends Controller
{
    public function index($myschedules_kywd = null)
    {
        $events = DB::table('tr_enrollment AS a')
            ->leftJoin('t_class_session AS b', 'b.id', '=', 'a.class_session_id')
            ->leftJoin('tm_trainer_data AS c', 'c.id', '=', 'b.trainer_id')
            ->leftJoin('miegacoa_employees.emp_employee AS d', 'd.nip', '=', 'c.nip')
            ->where('a.emp_nip', Auth::user()->nip)
            ->get();
        return view('myschedules.index', compact('events'));
    }
}
