<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainerSchedulesController extends Controller
{
    public function index($trainerschedules_kywd = null)
    {
        $events = DB::table('t_class_session AS a')
            ->leftJoin('tm_trainer_data AS b', 'b.id', '=', 'a.trainer_id')
            ->leftJoin('miegacoa_employees.emp_employee AS c', 'c.nip', '=', 'b.nip')
            ->leftJoin('tm_location_type AS d', 'd.id', '=', 'a.loc_type_id')
            ->leftJoin('tm_training_center AS e', 'e.id', '=', 'a.tc_id')
            ->get();
        return view('trainerschedules.index', compact('events'));
    }
}
