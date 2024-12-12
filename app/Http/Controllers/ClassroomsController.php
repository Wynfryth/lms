<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassroomsController extends Controller
{
    public function index($class_id)
    {
        $class = DB::table('t_class_header as a')
            ->select('a.id AS classId', 'a.class_title', 'b.id AS sessionId', 'b.session_name', 'f.Employee_name as trainer_name', 'd.location_type', 'e.tc_name')
            ->leftJoin('t_class_session as b', 'b.class_id', '=', 'a.id')
            ->leftJoin('tm_trainer_data as c', 'c.id', '=', 'b.trainer_id')
            ->leftJoin('tm_location_type as d', 'd.id', '=', 'b.loc_type_id')
            ->leftJoin('tm_training_center as e', 'e.id', '=', 'b.tc_id')
            ->leftJoin('miegacoa_employees.emp_employee as f', 'f.nip', '=', 'c.nip')
            ->where('a.id', $class_id)
            ->orderBy('b.session_order', 'asc')
            ->get();
        return view('classrooms.index', compact('class'));
    }

    public function getClassSessions(Request $request)
    {
        $classSessions = DB::table('t_class_header AS a')
            ->select('a.id AS class_id', 'a.class_title', 'b.*')
            ->leftJoin('t_class_session AS b', 'b.class_id', '=', 'a.id')
            ->where('a.id', $request->class_id)
            ->get();
        return $classSessions;
    }

    public function getSessionSchedule($sessionId)
    {
        $sessionSchedules = DB::table('t_class_session AS a')
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
                'c.id AS study_id',
                'c.study_material_title',
                'd.id AS test_id',
                'd.test_name',
                'h.type'
            )
            ->selectRaw(DB::raw(
                '(SELECT COUNT(*) FROM t_session_material_schedule WHERE class_session_id = a.id) AS session_schedule_count,
                CASE
                    WHEN NOW() BETWEEN b.start_eff_date AND b.end_eff_date THEN "OPEN"
                    ELSE "CLOSED"
                END AS schedule_status'
            ))
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
            ->leftJoin('class_material_types AS h', 'h.id', '=', 'b.material_type')
            ->where('a.id', $sessionId)
            ->orderBy('a.session_order', 'asc')
            ->orderBy('b.start_eff_date', 'asc')
            ->paginate(10);
        return view('classrooms.classSession', compact('sessionSchedules'));
    }
}
