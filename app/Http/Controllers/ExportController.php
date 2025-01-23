<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\QueryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\YourModel;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function exportGraduationRate()
    {
        // The query for the export
        $graduationRateResult = DB::table('tr_enrollment AS a')
            ->selectRaw('
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
            )->groupBy('b.id')
            ->get();

        // Export data as an array
        $data = $graduationRateResult->map(function ($item) {
            return (array) $item;
        })->toArray();

        // Return the export
        return Excel::download(new QueryExport($data), 'graduation_rate.xlsx');
    }

    public function exportMortalityRate()
    {
        // The query for the export
        $graduationRateResult = DB::table('tr_enrollment AS a')
            ->selectRaw('
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
            )->groupBy('b.id')
            ->get();

        // Export data as an array
        $data = $graduationRateResult->map(function ($item) {
            return (array) $item;
        })->toArray();

        // Return the export
        return Excel::download(new QueryExport($data), 'mortality_rate.xlsx');
    }
}
