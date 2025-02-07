<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function classPerformance($report_kywd = null, $year = null)
    {
        $reportYear = $year;
        if ($year) {
        } else {
            $year = date('Y');
        }
        $graduationRateResult = DB::table('tr_enrollment AS a')
            ->selectRaw('
                b.id,
                b.class_title,
                b.start_eff_date,
                b.end_eff_date,
                b.is_released,
                c.total_session,
                e.class_category,
                IF(d.total_material IS NOT NULL, d.total_material, 0) AS total_material,
                COUNT(a.id) AS total_enrollment,
                SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END) AS registered,
                SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END) AS ongoing,
                SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END) AS passed,
                SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END) AS failed,
                SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END) AS cancelled
            ')
            ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
            ->leftJoinSub(
                DB::table('t_class_header AS a')
                    ->selectRaw('a.id, COUNT(b.id) AS total_session')
                    ->leftJoin('t_class_session AS b', 'b.class_id', '=', 'a.id')
                    ->groupBy('a.id'),
                'c',
                'c.id',
                '=',
                'b.id'
            )
            ->leftJoinSub(
                DB::table('t_class_header AS a')
                    ->selectRaw('a.id, COUNT(c.id) AS total_material')
                    ->leftJoin('t_class_session AS b', 'b.class_id', '=', 'a.id')
                    ->leftJoin('t_session_material_schedule AS c', 'c.class_session_id', '=', 'b.id')
                    ->where('c.material_type', '=', 1)
                    ->groupBy('a.id'),
                'd',
                'd.id',
                '=',
                'b.id'
            )
            ->leftJoin('tm_class_category AS e', 'e.id', '=', 'b.class_category_id')
            // ->whereYear('a.enrollment_date', '=', $year)
            ->groupBy('b.id');
        if ($report_kywd != null) {
            $any_params = [
                'b.class_title',
            ];
            $graduationRateResult->whereAny($any_params, 'like', '%' . $report_kywd . '%');
        }
        $graduationRateResult = $graduationRateResult->paginate(10);

        return view('reports.graduationRate', compact('graduationRateResult', 'report_kywd'));
    }

    public function studentGraduationRate($report_kywd = null, $year = null)
    {
        $studentsData = DB::table('tr_enrollment AS a')
            ->select(
                DB::raw('GROUP_CONCAT(DISTINCT a.emp_nip) AS emp_nip'),
                DB::raw('GROUP_CONCAT(DISTINCT c.Employee_name) AS Employee_name'),
                DB::raw('GROUP_CONCAT(DISTINCT c.Organization) AS divisi'),
                DB::raw('COUNT(a.id) AS all_classes'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END) AS registered'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END) AS ongoing'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END) AS passed'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END) AS failed'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END) AS cancelled')
            )
            ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
            ->leftJoin('miegacoa_employees.emp_employee AS c', 'c.nip', '=', 'a.emp_nip')
            // ->whereYear('a.enrollment_date', '=', $year)
            ->groupBy('a.emp_nip')
            ->paginate(10);
        return view('reports.studentGraduationRate', compact('report_kywd', 'studentsData'));
    }

    public function mortalityRate($report_kywd = null, $year = null)
    {
        $reportYear = $year;
        if ($year) {
        } else {
            $year = date('Y');
        }
        $graduationRateResult = DB::table('tr_enrollment AS a')
            ->selectRaw('
                b.id,
                b.class_title,
                b.start_eff_date,
                b.end_eff_date,
                c.total_session,
                IF(d.total_material IS NOT NULL, d.total_material, 0) AS total_material,
                COUNT(a.id) AS total_enrollment,
                SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END) AS registered,
                SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END) AS ongoing,
                SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END) AS passed,
                SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END) AS failed,
                SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END) AS cancelled
            ')
            ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
            ->leftJoinSub(
                DB::table('t_class_header AS a')
                    ->selectRaw('a.id, COUNT(b.id) AS total_session')
                    ->leftJoin('t_class_session AS b', 'b.class_id', '=', 'a.id')
                    ->groupBy('a.id'),
                'c',
                'c.id',
                '=',
                'b.id'
            )
            ->leftJoinSub(
                DB::table('t_class_header AS a')
                    ->selectRaw('a.id, COUNT(c.id) AS total_material')
                    ->leftJoin('t_class_session AS b', 'b.class_id', '=', 'a.id')
                    ->leftJoin('t_session_material_schedule AS c', 'c.class_session_id', '=', 'b.id')
                    ->where('c.material_type', '=', 1)
                    ->groupBy('a.id'),
                'd',
                'd.id',
                '=',
                'b.id'
            )
            // ->whereYear('a.enrollment_date', '=', $year)
            ->groupBy('b.id');
        if ($report_kywd != null) {
            $any_params = [
                'b.class_title',
            ];
            $graduationRateResult->whereAny($any_params, 'like', '%' . $report_kywd . '%');
        }
        $graduationRateResult = $graduationRateResult->paginate(10);

        return view('reports.mortalityRate', compact('graduationRateResult', 'report_kywd'));
    }

    public function classPerformanceDetail($class_id)
    {
        $classDetail = DB::table('tr_enrollment AS a')
            ->leftJoin('miegacoa_employees.emp_employee AS b', 'b.nip', '=', 'a.emp_nip')
            ->leftJoin('tm_enrollment_status AS c', 'c.id', '=', 'a.enrollment_status_id')
            ->where('a.class_id', $class_id)
            ->get();
        return response()->json($classDetail);
    }
}
