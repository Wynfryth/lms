<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassroomsController extends Controller
{
    public function index($class_id, $role)
    {
        switch ($role) {
            case "Student":
                $class = DB::table('t_class_header as a')
                    ->select(
                        'a.id AS classId',
                        'a.class_title',
                        'b.id AS activityId',
                        'sm.id AS studyId',
                        'sm.study_material_title',
                        't.id AS testId',
                        't.test_name',
                        // '',
                        'a.is_released',
                        DB::raw("CASE
                            WHEN sm.id IS NOT NULL THEN 'Materi'
                            WHEN t.id IS NOT NULL THEN 'Tes'
                            ELSE NULL
                        END AS activity_type")
                    )
                    ->leftJoin('t_class_activity AS b', 'a.id', '=', 'b.class_header_id')

                    // Join to tm_study_material_header if activity_type = 'materi'
                    ->leftJoin('tm_study_material_header as sm', function ($join) {
                        $join->on('b.activity_id', '=', 'sm.id')
                            ->where('b.activity_type', '=', 'materi');
                    })

                    // Join to tm_test if activity_type = 'tes'
                    ->leftJoin('tm_test as t', function ($join) {
                        $join->on('b.activity_id', '=', 't.id')
                            ->where('b.activity_type', '=', 'tes');
                    })

                    ->where('a.id', $class_id)
                    ->orderBy('b.activity_order', 'asc')
                    ->get();
                break;
            case "Instructor":
                $class = DB::table('t_class_header as a')
                    ->select('a.id AS classId', 'a.class_title', 'b.id AS sessionId', 'b.session_name', 'a.is_released')
                    ->leftJoin('t_class_activity AS b', 'a.id', '=', 'b.class_header_id')
                    // Join to tm_study_material_header if activity_type = 'materi'
                    ->leftJoin('tm_study_material_header as sm', function ($join) {
                        $join->on('b.activity_id', '=', 'sm.id')
                            ->where('b.activity_type', '=', 'materi');
                    })

                    // Join to tm_test if activity_type = 'tes'
                    ->leftJoin('tm_test as t', function ($join) {
                        $join->on('b.activity_id', '=', 't.id')
                            ->where('b.activity_type', '=', 'tes');
                    })
                    ->where(
                        [
                            'a.id' => $class_id,
                            'f.nip' => Auth::user()->nip
                        ]
                    )
                    ->orderBy('b.session_order', 'asc')
                    ->get();
                break;
        }

        return view('classrooms.index', compact('class', 'role'));
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

    /* NOT USING SESSION ANYMORE. THIS FUNCTION MAYBE DEPRECATED!! */
    public function getSessionSchedule($sessionId, $role)
    {
        switch ($role) {
            case "Student":
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
                        // 'f.Employee_name AS trainer',
                        // 'g.location_type',
                        'c.id AS study_id',
                        'c.study_material_title',
                        'd.id AS test_id',
                        'd.test_name',
                        'd.pass_point',
                        'd.is_released AS test_is_released',
                        // 'h.type',
                        'i.id AS emp_test_id',
                        'j.result_point'
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
                    // ->leftJoin('tm_trainer_data AS e', 'e.id', '=', 'a.trainer_id')
                    // ->leftJoin(config('custom.employee_db') . '.emp_employee AS f', 'f.nip', '=', 'e.nip')
                    // ->leftJoin('tm_location_type AS g', 'g.id', '=', 'a.loc_type_id')
                    // ->leftJoin('class_material_types AS h', 'h.id', '=', 'b.material_type')
                    ->leftJoin('tr_emp_test AS i', function ($join) {
                        $nip = Auth::user()->nip;
                        $join->on('i.test_sch_id', '=', 'b.id')
                            ->where(
                                [
                                    'b.material_type' => 2,
                                    'i.emp_nip' => $nip
                                ]
                            );
                    })
                    ->leftJoin(DB::raw('(SELECT
                                    GROUP_CONCAT(a.id) AS studentTestId, a.emp_test_id, GROUP_CONCAT(a.question_id) AS question_id,
                                    GROUP_CONCAT(a.answer_id) AS answer_id, GROUP_CONCAT(b.answer) AS answer, GROUP_CONCAT(b.correct_status) AS correct_status,
                                    GROUP_CONCAT(c.question) AS question, GROUP_CONCAT(c.points) AS points,
                                    SUM(c.points) AS max_point,
                                    SUM(CASE WHEN b.correct_status = 1 THEN 1 ELSE 0 END) AS total_correct,
                                    SUM(CASE WHEN correct_status = 1 THEN c.points ELSE 0 END) AS result_point
                                    FROM tr_emp_answer AS a
                                    LEFT JOIN tm_answer_bank AS b ON b.id = a.answer_id
                                    LEFT JOIN tm_question_bank AS c ON c.id = b.question_id
                                    GROUP BY a.emp_test_id) AS j'), 'j.emp_test_id', '=', 'i.id')
                    ->where('a.id', $sessionId)
                    ->orderBy('a.session_order', 'asc')
                    ->orderBy('b.start_eff_date', 'asc')
                    ->paginate(10);
                break;
            case "Instructor":
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
                        // 'f.Employee_name AS trainer',
                        // 'g.location_type',
                        'c.id AS study_id',
                        'c.study_material_title',
                        'd.id AS test_id',
                        'd.test_name',
                        'd.pass_point',
                        'd.is_released AS test_is_released',
                        // 'h.type',
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
                    // ->leftJoin('tm_trainer_data AS e', 'e.id', '=', 'a.trainer_id')
                    // ->leftJoin(config('custom.employee_db') . '.emp_employee AS f', 'f.nip', '=', 'e.nip')
                    // ->leftJoin('tm_location_type AS g', 'g.id', '=', 'a.loc_type_id')
                    ->leftJoin('class_material_types AS h', 'h.id', '=', 'b.material_type')
                    // ->leftJoin('tr_emp_test AS i', function ($join) {
                    //     $nip = Auth::user()->nip;
                    //     $join->on('i.test_sch_id', '=', 'b.id')
                    //         ->where(
                    //             [
                    //                 'b.material_type' => 2,
                    //                 'i.emp_nip' => $nip
                    //             ]
                    //         );
                    // })
                    // ->leftJoin(DB::raw('(SELECT
                    //                 GROUP_CONCAT(a.id) AS studentTestId, a.emp_test_id, GROUP_CONCAT(a.question_id) AS question_id,
                    //                 GROUP_CONCAT(a.answer_id) AS answer_id, GROUP_CONCAT(b.answer) AS answer, GROUP_CONCAT(b.correct_status) AS correct_status,
                    //                 GROUP_CONCAT(c.question) AS question, GROUP_CONCAT(c.points) AS points,
                    //                 SUM(c.points) AS max_point,
                    //                 SUM(CASE WHEN b.correct_status = 1 THEN 1 ELSE 0 END) AS total_correct,
                    //                 SUM(CASE WHEN correct_status = 1 THEN c.points ELSE 0 END) AS result_point
                    //                 FROM tr_emp_answer AS a
                    //                 LEFT JOIN tm_answer_bank AS b ON b.id = a.answer_id
                    //                 LEFT JOIN tm_question_bank AS c ON c.id = b.question_id
                    //                 GROUP BY a.emp_test_id) AS j'), 'j.emp_test_id', '=', 'i.id')
                    ->where(['a.id' => $sessionId])
                    ->orderBy('a.session_order', 'asc')
                    ->orderBy('b.start_eff_date', 'asc')
                    ->paginate(10);
                break;
        }

        return view('classrooms.classSession', compact('sessionSchedules', 'role'));
    }

    public function getEmpTestScore($nip, $activityId) {}
}
