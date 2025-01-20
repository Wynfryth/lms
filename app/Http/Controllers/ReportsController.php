<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function graduationRate($class_name = null, $year = null)
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
            ->whereYear('a.enrollment_date', '=', $year)
            ->groupBy('b.id')
            ->get();

        return view('reports.graduationRate', compact('graduationRateResult'));
    }
}
