<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\QueryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\YourModel;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function classPerformance()
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
                SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END) AS failed,
                ROUND((SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END) / COUNT(a.id)) * 100, 2) AS failed_percentage,
                SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END) AS passed,
                ROUND((SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END) / COUNT(a.id)) * 100, 2) AS pass_percentage
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

        $headings = [
            'Kelas',
            'Mulai',
            'Sampai',
            'Jumlah Sesi',
            'Jumlah Materi',
            'Jumlah Peserta',
            'Gagal',
            'Persentase Kegagalan (%)',
            'Lulus',
            'Persentase Kelulusan (%)',
        ];

        // Return the export
        return Excel::download(new QueryExport($data, $headings), 'graduationRate_export.xlsx');
    }

    public function classPerformanceDetail($class_id)
    {
        $classDetail = DB::table('tr_enrollment AS a')
            ->select(
                'd.class_title',
                'e.class_category',
                'd.start_eff_date',
                'd.end_eff_date',
                'b.Employee_name',
                'f.enrollment_status',
                'a.class_score'
            )
            ->leftJoin(config('custom.employee_db') . '.emp_employee AS b', 'b.nip', '=', 'a.emp_nip')
            ->leftJoin('tm_enrollment_status AS c', 'c.id', '=', 'a.enrollment_status_id')
            ->leftJoin('t_class_header AS d', 'd.id', '=', 'a.class_id')
            ->leftJoin('tm_class_category AS e', 'e.id', '=', 'd.class_category_id')
            ->leftJoin('tm_enrollment_status AS f', 'f.id', '=', 'a.enrollment_status_id')
            ->where('a.class_id', $class_id)
            ->get();

        // Export data as an array
        $data = $classDetail->map(function ($item) {
            return (array) $item;
        })->toArray();

        $headings = [
            'Kelas',
            'Kategori Kelas',
            'Mulai',
            'Sampai',
            'Nama',
            'Status Kepesertaan',
            'Nilai Kelas',
        ];

        // Return the export
        return Excel::download(new QueryExport($data, $headings), 'Performa Kelas - ' . $classDetail[0]->class_title . ' (' . date('d.m.Y', strtotime($classDetail[0]->start_eff_date)) . '-' . date('d.m.Y', strtotime($classDetail[0]->end_eff_date)) . ').xlsx');
    }

    public function mortalityRate()
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
            SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END) AS failed,
            ROUND((SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END) / COUNT(a.id)) * 100, 2) AS failed_percentage
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

        $headings = [
            'Kelas',
            'Mulai',
            'Sampai',
            'Jumlah Sesi',
            'Jumlah Materi',
            'Jumlah Peserta',
            'Gagal',
            'Persentase Kegagalan (%)',
        ];

        // Return the export
        return Excel::download(new QueryExport($data, $headings), 'moratlityRate_export.xlsx');
    }

    public function studentPerformance()
    {
        $studentPerformance = DB::table('tr_enrollment AS a')
            ->select(
                DB::raw('GROUP_CONCAT(DISTINCT a.emp_nip) AS emp_nip'),
                DB::raw('GROUP_CONCAT(DISTINCT c.Employee_name) AS Employee_name'),
                DB::raw('GROUP_CONCAT(DISTINCT c.Organization) AS divisi'),
                DB::raw('COUNT(a.id) AS all_classes'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 1 THEN 1 ELSE 0 END) AS registered'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 2 THEN 1 ELSE 0 END) AS ongoing'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END) AS passed'),
                DB::raw('ROUND((SUM(CASE WHEN a.enrollment_status_id = 3 THEN 1 ELSE 0 END) / COUNT(a.id)) * 100, 2) AS pass_percentage'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END) AS failed'),
                DB::raw('ROUND((SUM(CASE WHEN a.enrollment_status_id = 4 THEN 1 ELSE 0 END) / COUNT(a.id)) * 100, 2) AS failed_percentage'),
                DB::raw('SUM(CASE WHEN a.enrollment_status_id = 5 THEN 1 ELSE 0 END) AS cancelled')
            )
            ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
            ->leftJoin(config('custom.employee_db') . '.emp_employee AS c', 'c.nip', '=', 'a.emp_nip')
            // ->whereYear('a.enrollment_date', '=', $year)
            ->groupBy('a.emp_nip')
            ->get();

        // Export data as an array
        $data = $studentPerformance->map(function ($item) {
            return (array) $item;
        })->toArray();

        $headings = [
            'NIP',
            'nama',
            'Divisi',
            'Jumlah Kelas',
            'Terdaftar',
            'Sedang Mengikuti',
            'Lulus',
            'Persentase Kelulusan (%)',
            'Gagal',
            'Persentase Kegagalan (%)',
            'Dibatalkan',
        ];

        // Return the export
        return Excel::download(new QueryExport($data, $headings), 'studentPerformance_export.xlsx');
    }

    public function tests($classId)
    {
        $rankedAnswers = DB::table('tm_test as a')
            ->selectRaw("
                a.id as test_id,
                a.test_code,
                a.test_name,
                c.question,
                d.answer,
                d.correct_status,
                c.points,
                ROW_NUMBER() OVER (PARTITION BY c.id ORDER BY d.correct_status DESC) as answer_rank
            ")
            ->leftJoin('test_has_questions as b', 'b.test_id', '=', 'a.id')
            ->leftJoin('tm_question_bank as c', 'c.id', '=', 'b.question_id')
            ->leftJoin('tm_answer_bank as d', 'd.question_id', '=', 'c.id')
            ->where('a.id', $classId);

        // Step 2: Use the "RankedAnswers" query as a subquery
        $test = DB::table(DB::raw("({$rankedAnswers->toSql()}) as RankedAnswers"))
            ->selectRaw("
                test_code,
                test_name,
                question,
                MAX(CASE WHEN answer_rank = 1 THEN answer END) AS option_1,
                MAX(CASE WHEN answer_rank = 2 THEN answer END) AS option_2,
                MAX(CASE WHEN answer_rank = 3 THEN answer END) AS option_3,
                MAX(CASE WHEN answer_rank = 4 THEN answer END) AS option_4,
                MAX(CASE WHEN answer_rank = 5 THEN answer END) AS option_5,
                MAX(CASE WHEN correct_status = 1 THEN answer END) AS correct_answer,
                points
            ")
            ->mergeBindings($rankedAnswers) // Ensures bindings from subquery are applied
            ->groupBy('test_id', 'test_code', 'test_name', 'question', 'points')
            ->get();

        count($test) > 0 ? $test_name = $test[0]->test_name : $test_name = 'unknownTest';

        // Export data as an array
        $data = $test->map(function ($item) {
            return (array) $item;
        })->toArray();

        $headings = [
            'Kode Tes',
            'Tes',
            'Pertanyaan',
            'Option 1',
            'Option 2',
            'Option 3',
            'Option 4',
            'Option 5',
            'Kunci Jawaban',
            'Poin',
        ];

        // Return the export
        return Excel::download(new QueryExport($data, $headings), $test_name . '_export.xlsx');
    }
}
