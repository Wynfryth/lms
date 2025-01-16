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
            ->select('a.id', 'b.id AS class_id', 'b.class_title', 'b.class_desc', 'b.start_eff_date', 'b.end_eff_date', 'd.enrollment_status', 'b.is_released')
            ->selectRaw(DB::raw('GROUP_CONCAT(DISTINCT c.id) AS session_ids, GROUP_CONCAT(c.session_name) AS session_name, COUNT(e.id) AS all_test, COUNT(e.emp_test_id) AS test_done'))
            ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
            ->leftJoin('t_class_session AS c', 'c.class_id', '=', 'b.id')
            ->leftJoin('tm_enrollment_status AS d', 'd.id', '=', 'a.enrollment_status_id')
            ->leftJoin(DB::raw('(SELECT
                a.id, GROUP_CONCAT(DISTINCT a.class_session_id) AS class_session_id, GROUP_CONCAT(DISTINCT a.material_id) AS material_ids, GROUP_CONCAT(DISTINCT c.emp_test_id) AS emp_test_id,
                GROUP_CONCAT(DISTINCT c.question_id) AS question_ids
                FROM t_session_material_schedule AS a
                LEFT JOIN tr_emp_test AS b ON b.test_sch_id = a.id
                LEFT JOIN tr_emp_answer AS c ON c.emp_test_id = b.id
                WHERE material_type = 2
                GROUP BY a.id) AS e'), 'e.class_session_id', '=', 'c.id')
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
        $myclasses = $myclasses->paginate(10);
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
}
