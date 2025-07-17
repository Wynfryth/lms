<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyClassesController extends Controller
{
    public function index($myclasses_kywd = null)
    {
        $nip = Auth::user()->nip;
        $myclasses = DB::table('tr_enrollment AS a')
            ->select('a.id', 'b.id AS class_id', 'b.class_title', 'b.class_desc', 'b.start_eff_date', 'b.start_eff_time', 'd.enrollment_status', 'b.is_released', 'f.id AS feedbackId')
            ->selectRaw(DB::raw('GROUP_CONCAT(DISTINCT c.id) AS session_ids, COUNT(e.id) AS all_test, COUNT(e.emp_test_id) AS test_done'))
            ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
            ->leftJoin('t_class_activity AS c', 'c.class_header_id', '=', 'b.id')
            ->leftJoin('tm_enrollment_status AS d', 'd.id', '=', 'a.enrollment_status_id')
            ->leftJoinSub(
                DB::table('t_class_activity AS a')
                    ->select([
                        'a.id',
                        // DB::raw('GROUP_CONCAT(DISTINCT a.class_session_id) AS class_session_id'),
                        // DB::raw('GROUP_CONCAT(DISTINCT a.material_id) AS material_ids'),
                        DB::raw('GROUP_CONCAT(DISTINCT c.emp_test_id) AS emp_test_id'),
                        DB::raw('GROUP_CONCAT(DISTINCT c.question_id) AS question_ids')
                    ])
                    ->leftJoin('tr_emp_test AS b', function ($join) {
                        $join->on('b.activity_id', '=', 'a.id')
                            ->where('b.emp_nip', '=', Auth::user()->nip);
                    })
                    ->leftJoin('tr_emp_answer AS c', 'c.emp_test_id', '=', 'b.id')
                    ->where('a.activity_type', 'tes')
                    ->groupBy('a.id'),
                'e',
                'e.id',
                '=',
                'c.id'
            )
            ->leftJoin('tr_feedback AS f', 'f.enrollmentId', '=', 'a.id')
            ->where('a.emp_nip', $nip)
            ->orderBy('a.id', 'desc')
            ->groupBy('a.id');
        if ($myclasses_kywd != null) {
            $any_params = [
                'b.class_title',
                'b.class_desc',
                'd.enrollment_status'
            ];
            $myclasses->whereAny($any_params, 'like', '%' . $myclasses_kywd . '%');
        }
        $myclasses = $myclasses->paginate(12);
        return view('myclasses.index', compact('myclasses', 'myclasses_kywd'));
    }

    public function passStatusCheck($class_sessions)
    {
        $classSessionIdsArray = explode(',', $class_sessions); // Convert to array for query builder

        $query = DB::table('t_session_material_schedule AS a')
            ->selectRaw('
                a.id,
                a.class_session_id,
                a.material_percentage,
                GROUP_CONCAT(DISTINCT d.test_id) AS test_id,
                GROUP_CONCAT(DISTINCT d.pass_point) AS pass_point,
                GROUP_CONCAT(DISTINCT e.id) AS test_sch_id,
                GROUP_CONCAT(f.id) AS emp_test_id,
                GROUP_CONCAT(g.answer_id) AS answer_ids,
                GROUP_CONCAT(h.correct_status) AS correct_status,
                GROUP_CONCAT(i.points) AS points,
                SUM(CASE WHEN h.correct_status = 1 THEN i.points ELSE 0 END) AS result_point
            ')
            ->leftJoinSub(
                DB::table('t_test_with_materials_list AS b')
                    ->selectRaw('
                        c.id AS test_id,
                        b.study_materials_id,
                        c.pass_point
                    ')
                    ->leftJoin('tm_test AS c', function ($join) {
                        $join->on('c.id', '=', 'b.test_id')
                            ->where('c.test_cat_id', '=', 3);
                    }),
                'd',
                function ($join) {
                    $join->on('d.study_materials_id', '=', 'a.material_id')
                        ->whereNotNull('d.test_id');
                }
            )
            ->leftJoin('t_session_material_schedule AS e', function ($join) use ($classSessionIdsArray) {
                $join->on('e.material_id', '=', 'd.test_id')
                    ->where('e.material_type', '=', 2)
                    ->whereIn('e.class_session_id', $classSessionIdsArray);
            })
            ->leftJoin('tr_emp_test AS f', 'f.test_sch_id', '=', 'e.id')
            ->leftJoin('tr_emp_answer AS g', 'g.emp_test_id', '=', 'f.id')
            ->leftJoin('tm_answer_bank AS h', 'h.id', '=', 'g.answer_id')
            ->leftJoin('tm_question_bank AS i', 'i.id', '=', 'g.question_id')
            ->whereIn('a.class_session_id', $classSessionIdsArray)
            ->where('a.material_type', '=', 1)
            ->groupBy('a.id');

        // Execute the query
        $result = $query->get();
        return $result;
    }

    public function certificate($class_id, $nip)
    {
        $certificateData = DB::table('tr_enrollment AS a')
            ->select('c.Employee_name', 'b.class_title', 'd.enrollment_status')
            ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
            ->leftJoin(config('custom.employee_db') . '.emp_employee AS c', 'c.nip', '=', 'a.emp_nip')
            ->leftJoin('tm_enrollment_status AS d', 'd.id', '=', 'a.enrollment_status_id')
            ->where([
                ['a.class_id', '=', $class_id],
                ['a.emp_nip', '=', $nip],
            ])
            ->first();
        return view('myclasses.certificate', compact('certificateData'));
    }
}
