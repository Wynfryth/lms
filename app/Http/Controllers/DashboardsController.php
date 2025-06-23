<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardsController extends Controller
{
    public function index($year = null)
    {
        $dashboardYear = $year;
        if ($year) {
        } else {
            $year = date('Y');
        }

        $allClassesYearBefore = DB::table('tr_enrollment AS a')
            ->selectRaw('COUNT(a.id) AS all_classes')
            ->whereRaw('YEAR(a.enrollment_date) = ?', [$year - 1])
            ->first();

        switch (Auth::user()->roles->pluck('name')[0]) {
            case "Academy Admin":
                /* all attended classes in that year */
                $whereParams = [
                    ['a.enrollment_status_id', '!=', 5],
                ];
                $attendedClasses = DB::table('tr_enrollment AS a')
                    ->selectRaw('COALESCE(COUNT(a.id), 0) AS all_classes,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->first();

                /* all attended pre-classes in that year */
                $whereParams = [
                    ['d.id', '=', 2],
                ];
                $attendedPreClasses = DB::table('tr_enrollment AS a')
                    ->selectRaw('COALESCE(COUNT(a.id), 0) AS all_classes,
                        COALESCE(SUM(CASE WHEN c.id = 4 THEN 1 ELSE 0 END), 0) AS tos,
                        COALESCE(SUM(CASE WHEN c.id = 5 THEN 1 ELSE 0 END), 0) AS sos,
                        COALESCE(SUM(CASE WHEN c.id = 6 THEN 1 ELSE 0 END), 0) AS mos,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
                    ->leftJoin('tm_class_category AS c', 'c.id', '=', 'b.class_category_id')
                    ->leftJoin('tm_class_type AS d', 'd.id', '=', 'b.class_type_id')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->first();

                /* all attended training-classes in that year */
                $whereParams = [
                    ['d.id', '=', 1],
                ];
                $attendedTrainingClasses = DB::table('tr_enrollment AS a')
                    ->selectRaw('COALESCE(COUNT(a.id), 0) AS all_classes,
                        COALESCE(SUM(CASE WHEN c.id = 1 THEN 1 ELSE 0 END), 0) AS tos,
                        COALESCE(SUM(CASE WHEN c.id = 2 THEN 1 ELSE 0 END), 0) AS sos,
                        COALESCE(SUM(CASE WHEN c.id = 3 THEN 1 ELSE 0 END), 0) AS mos,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
                    ->leftJoin('tm_class_category AS c', 'c.id', '=', 'b.class_category_id')
                    ->leftJoin('tm_class_type AS d', 'd.id', '=', 'b.class_type_id')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->first();

                /* all attended classes in that year in monthly */
                $monthlyClasses = DB::table(DB::raw('(SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                                            SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL
                                            SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) months'))
                    ->leftJoin('tr_enrollment AS a', function ($join) use ($year) {
                        $join->on(DB::raw('MONTH(a.enrollment_date)'), '=', 'months.month')
                            ->whereYear('a.enrollment_date', '=', $year);
                    })
                    ->select(
                        'months.month',
                        DB::raw('COALESCE(IF(COUNT(a.id) != 0, COUNT(a.id), 0), 0) AS all_classes'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    )
                    ->groupBy('months.month')
                    ->orderBy('months.month')
                    ->get();

                break;
            case "Student":
                $nip = Auth::user()->nip;

                /* all attended classes in that year */
                $whereParams = [
                    ['a.emp_nip', '=', $nip],
                    ['a.enrollment_status_id', '!=', 5],
                ];
                $attendedClasses = DB::table('tr_enrollment AS a')
                    ->selectRaw('COALESCE(COUNT(a.id), 0) AS all_classes,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->first();

                /* all attended pre-classes in that year */
                $whereParams = [
                    ['a.emp_nip', '=', $nip],
                    ['d.id', '=', 1],
                ];
                $attendedPreClasses = DB::table('tr_enrollment AS a')
                    ->selectRaw('
                        COALESCE(COUNT(a.id), 0) AS all_classes,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled
                    ')
                    ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
                    ->leftJoin('tm_class_category AS c', 'c.id', '=', 'b.class_category_id')
                    ->leftJoin('tm_class_type AS d', 'd.id', '=', 'b.class_type_id')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->first();

                /* all attended treining-classes in that year */
                $whereParams = [
                    ['a.emp_nip', '=', $nip],
                    ['d.id', '=', 2],
                ];
                $attendedTrainingClasses = DB::table('tr_enrollment AS a')
                    ->selectRaw('
                        COALESCE(COUNT(a.id), 0) AS all_classes,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed,
                        COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
                    ->leftJoin('tm_class_category AS c', 'c.id', '=', 'b.class_category_id')
                    ->leftJoin('tm_class_type AS d', 'd.id', '=', 'b.class_type_id')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->first();

                /* all attended classes in that year in monthly */
                $monthlyClasses = DB::table(DB::raw('(SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                                                    SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL
                                                    SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) months'))
                    ->leftJoin('tr_enrollment AS a', function ($join) use ($year, $nip) {
                        $join->on(DB::raw('MONTH(a.enrollment_date)'), '=', 'months.month')
                            ->whereYear('a.enrollment_date', '=', $year)
                            ->where('a.emp_nip', '=', $nip);
                    })
                    ->select(
                        'a.emp_nip',
                        'months.month',
                        DB::raw('COALESCE(IF(COUNT(a.id) != 0, COUNT(a.id), 0), 0) AS all_classes'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    )
                    ->groupBy('a.emp_nip', 'months.month')
                    ->orderBy('months.month')
                    ->get();
                break;
            case "Instructor":
                $nip = Auth::user()->nip;

                /* all attended classes in that year */
                $whereParams = [
                    ['d.nip', '=', $nip],
                    ['a.enrollment_status_id', '!=', 5],
                ];
                $attendedClasses = DB::table('tr_enrollment AS a')
                    ->selectRaw('COALESCE(COUNT(a.id), 0) AS all_classes,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
                    ->leftJoin('t_class_session AS c', 'c.class_id', '=', 'b.id')
                    ->leftJoin('tm_trainer_data AS d', 'd.id', '=', 'c.trainer_id')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->first();

                /* all attended pre-classes in that year */
                $whereParams = [
                    ['f.nip', '=', $nip],
                    ['d.id', '=', 1],
                ];
                $attendedPreClasses = DB::table('tr_enrollment AS a')
                    ->selectRaw('
                            COALESCE(COUNT(a.id), 0) AS all_classes,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled
                        ')
                    ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
                    ->leftJoin('tm_class_category AS c', 'c.id', '=', 'b.class_category_id')
                    ->leftJoin('tm_class_type AS d', 'd.id', '=', 'b.class_type_id')
                    ->leftJoin('t_class_session AS e', 'e.class_id', '=', 'b.id')
                    ->leftJoin('tm_trainer_data AS f', 'f.id', '=', 'e.trainer_id')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->first();

                /* all attended treining-classes in that year */
                $whereParams = [
                    ['f.nip', '=', $nip],
                    ['d.id', '=', 2],
                ];
                $attendedTrainingClasses = DB::table('tr_enrollment AS a')
                    ->selectRaw('
                            COALESCE(COUNT(a.id), 0) AS all_classes,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed,
                            COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
                    ->leftJoin('tm_class_category AS c', 'c.id', '=', 'b.class_category_id')
                    ->leftJoin('tm_class_type AS d', 'd.id', '=', 'b.class_type_id')
                    ->leftJoin('t_class_session AS e', 'e.class_id', '=', 'b.id')
                    ->leftJoin('tm_trainer_data AS f', 'f.id', '=', 'e.trainer_id')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->first();

                /* all attended classes in that year in monthly */
                $monthlyClasses = DB::table(DB::raw('(SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL
                                                        SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL
                                                        SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) months'))
                    ->leftJoin('tr_enrollment AS a', function ($join) use ($year, $nip) {
                        $join->on(DB::raw('MONTH(a.enrollment_date)'), '=', 'months.month')
                            ->whereYear('a.enrollment_date', '=', $year);
                        // ->where('a.emp_nip', '=', $nip);
                    })
                    ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
                    ->leftJoin('t_class_session AS c', 'c.class_id', '=', 'b.id')
                    ->leftJoin('tm_trainer_data AS d', 'd.id', '=', 'c.trainer_id')
                    ->select(
                        'a.emp_nip',
                        'months.month',
                        DB::raw('COALESCE(IF(COUNT(a.id) != 0, COUNT(a.id), 0), 0) AS all_classes'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END), 0) AS registered'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END), 0) AS ongoing'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END), 0) AS passed'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END), 0) AS failed'),
                        DB::raw('COALESCE(SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END), 0) AS cancelled')
                    )
                    ->where([
                        ['d.nip', '=', $nip],
                    ])
                    ->groupBy('a.emp_nip', 'months.month')
                    ->orderBy('months.month')
                    ->get();
                break;
        }

        return view('dashboard', compact('dashboardYear', 'attendedClasses', 'monthlyClasses', 'attendedPreClasses', 'attendedTrainingClasses', 'allClassesYearBefore'));
    }
}
