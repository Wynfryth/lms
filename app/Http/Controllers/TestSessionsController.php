<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestSessionsController extends Controller
{
    public function index($testId, $scheduleId)
    {
        $nip = Auth::user()->nip;
        $existedTest = DB::table('tr_emp_test AS a')
            ->where([
                'a.emp_nip' => $nip,
                'a.test_sch_id' => $scheduleId,
            ])
            ->first();
        if ($existedTest != null) {
            // ngecek dia udah submit belum, sebelum waktunya selesai
            $empTestId = $existedTest->id;
            $existedAnswer = DB::table('tr_emp_answer AS a')
                ->where([
                    'a.emp_test_id' => $empTestId
                ])
                ->first();
            if ($existedAnswer != null) {
                return redirect()->route('testSessions.testResult', ['nip' => Auth::user()->nip, 'studentTestId' => $existedTest->id, 'role' => '2']);
            } else {
                return redirect()->route('testSessions.questions', ['testScheduleId' => $existedTest->id, 'testId' => $testId]);
            }
            // if ($existedTest->time_end > Carbon::now()) {
            //     // ngecek dia udah submit belum, sebelum waktunya selesai
            //     $empTestId = $existedTest->id;
            //     $existedAnswer = DB::table('tr_emp_answer AS a')
            //         ->where([
            //             'a.emp_test_id' => $empTestId
            //         ])
            //         ->first();
            //     if ($existedAnswer != null) {
            //         return redirect()->route('testSessions.testResult', ['nip' => Auth::user()->nip, 'studentTestId' => $existedTest->id]);
            //     } else {
            //         return redirect()->route('testSessions.questions', ['testScheduleId' => $existedTest->id, 'testId' => $testId]);
            //     }
            // } else {
            //     return redirect()->route('testSessions.testResult', ['nip' => Auth::user()->nip, 'studentTestId' => $existedTest->id]);
            // }
        } else {
            $test = DB::table('tm_test AS a')
                ->select(
                    'a.id AS testId',
                    'a.test_name',
                    'a.test_desc',
                    'a.estimated_time',
                    'a.pass_point'
                )
                ->selectRaw('COUNT(c.id) AS total_questions, GROUP_CONCAT(c.id) AS questionId, SUM(c.points) AS total_points')
                ->leftJoin('test_has_questions AS b', 'a.id', '=', 'b.test_id')
                ->leftJoin('tm_question_bank AS c', 'b.question_id', '=', 'c.id')
                ->where('a.id', $testId)
                ->first();
            return view('classrooms.testSession', compact('test', 'scheduleId'));
        }
    }

    public function startStudentTest(Request $request)
    {
        $nip = Auth::user()->nip;
        $scheduleId = $request->scheduleId;
        $testId = $request->testId;
        // get estimated time for the test
        $test = DB::table('tm_test AS a')
            ->select('a.estimated_time')
            ->where('a.id', $testId)
            ->first();
        $estimatedTime = date('H:i:s', strtotime($test->estimated_time));
        $now = Carbon::now();
        list($hours, $minutes, $seconds) = explode(':', $estimatedTime);
        $now->addHours(intval($hours))
            ->addMinutes(intval($minutes))
            ->addSeconds(intval($seconds));
        $endTime = $now->format('Y-m-d H:i:s');
        // inserting data in emp_test
        $insertData = [
            'emp_nip' => $nip,
            'test_sch_id' => $scheduleId,
            'time_started' => Carbon::now(),
            'time_end' => $endTime,
        ];
        $insert_action = DB::table('tr_emp_test')
            ->insertGetId($insertData);
        return $insert_action;
    }

    public function questions($testScheduleId, $testId)
    {
        $questions = DB::table('tm_test AS a')
            ->select(
                'a.id AS test_id',
                'a.test_name',
                'a.test_desc',
                'a.is_active',
                'a.estimated_time',
                'a.pass_point',
                'c.id AS question_id',
                'c.question',
                'c.points'
            )
            ->selectRaw('GROUP_CONCAT(d.id SEPARATOR "|") AS answer_ids, GROUP_CONCAT(d.answer SEPARATOR "|") AS answers')
            ->leftJoin('test_has_questions AS b', 'b.test_id', '=', 'a.id')
            ->leftJoin('tm_question_bank AS c', 'c.id', '=', 'b.question_id')
            ->leftJoin('tm_answer_bank AS d', 'd.question_id', '=', 'c.id')
            ->where('a.id', $testId)
            ->groupBy('c.id')
            ->get();
        return view('classrooms.questions', compact('questions', 'testScheduleId'));
    }

    public function getCountdown($testScheduleId)
    {
        $testSchedule = DB::table('tr_emp_test AS a')
            ->select('a.time_end')
            ->where('a.id', $testScheduleId)
            ->first();
        return $endTime = date('Y-m-d H:i:s', strtotime($testSchedule->time_end));
    }

    public function submitTest(Request $request)
    {
        // check if the user has submitted the test
        $existedTest = DB::table('tr_emp_answer AS a')
            ->where('a.emp_test_id', $request->testScheduleId)
            ->count();
        if ($existedTest > 0) {
            $insert_answer_action = $existedTest;
        } else {
            $answers = $request->answers;
            foreach ($answers as $answer) {
                $insert_answer_data = [
                    'emp_test_id' => $request->testScheduleId,
                    'question_id' => key($answer),
                    'answer_id' => $answer[key($answer)]
                ];
                $insert_answer_action = DB::table('tr_emp_answer')->insert($insert_answer_data);
            }

            if ($insert_answer_action > 0) {
                $answer_result = DB::table('tr_emp_answer AS a')
                    ->selectRaw("
                        GROUP_CONCAT(a.id) AS emp_answer_ids,
                        a.emp_test_id,
                        GROUP_CONCAT(b.id) AS answer_ids,
                        GROUP_CONCAT(b.correct_status) AS correct_statuses,
                        SUM(CASE WHEN b.correct_status = 1 THEN c.points ELSE 0 END) AS point_result
                    ")
                    ->leftJoin('tm_answer_bank AS b', 'b.id', '=', 'a.answer_id')
                    ->leftJoin('tm_question_bank AS c', 'c.id', '=', 'a.question_id')
                    ->where('a.emp_test_id', $request->testScheduleId)
                    ->groupBy('a.emp_test_id')
                    ->first();
                $update_header = DB::table('tr_emp_test')
                    ->where('id', $request->testScheduleId)
                    ->update([
                        'test_score' => $answer_result->point_result
                    ]);
            }

            // ngecek apakah udah tes terakhir ato belum
            $classId = DB::table('tr_emp_test AS b')
                ->select('d.class_id', 'g.category_type')
                ->leftJoin('t_session_material_schedule AS c', 'c.id', '=', 'b.test_sch_id')
                ->leftJoin('t_class_session AS d', 'd.id', '=', 'c.class_session_id')
                ->leftJoin('t_class_header AS e', 'e.id', '=', 'd.class_id')
                ->leftJoin('tm_class_category AS f', 'f.id', '=', 'e.class_category_id')
                ->leftJoin('tm_class_category_type AS g', 'g.id', '=', 'f.class_category_type_id')
                ->where('b.id', $request->testScheduleId)
                ->first();
            $tests = DB::table('tr_enrollment AS a')
                ->select([
                    'a.id AS enrollment_id',
                    'b.id AS class_id',
                    'b.class_title',
                    'b.class_desc',
                    'b.start_eff_date',
                    'b.end_eff_date',
                    'd.enrollment_status',
                    'b.is_released',
                    DB::raw('GROUP_CONCAT(DISTINCT c.id) AS session_ids'),
                    DB::raw('GROUP_CONCAT(c.session_name) AS session_name'),
                    DB::raw('COUNT(e.id) AS all_test'),
                    DB::raw('COUNT(e.emp_test_id) AS test_done')
                ])
                ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
                ->leftJoin('t_class_session AS c', 'c.class_id', '=', 'b.id')
                ->leftJoin('tm_enrollment_status AS d', 'd.id', '=', 'a.enrollment_status_id')
                ->leftJoinSub(
                    DB::table('t_session_material_schedule AS a')
                        ->select([
                            'a.id',
                            DB::raw('GROUP_CONCAT(DISTINCT a.class_session_id) AS class_session_id'),
                            DB::raw('GROUP_CONCAT(DISTINCT a.material_id) AS material_ids'),
                            DB::raw('GROUP_CONCAT(DISTINCT c.emp_test_id) AS emp_test_id'),
                            DB::raw('GROUP_CONCAT(DISTINCT c.question_id) AS question_ids')
                        ])
                        ->leftJoin('tr_emp_test AS b', function ($join) {
                            $join->on('b.test_sch_id', '=', 'a.id')
                                ->where('b.emp_nip', '=', Auth::user()->nip);
                        })
                        ->leftJoin('tr_emp_answer AS c', 'c.emp_test_id', '=', 'b.id')
                        ->where('a.material_type', 2)
                        ->groupBy('a.id'),
                    'e',
                    'e.class_session_id',
                    '=',
                    'c.id'
                )
                ->where('a.emp_nip', Auth::user()->nip)
                ->where('a.class_id', $classId->class_id)
                ->groupBy('a.id')
                ->orderBy('a.id', 'desc')
                ->first();
            if ($tests->test_done > 0) {
                if ($tests->all_test == $tests->test_done) {
                    /* checking class
                        if preclass -> yang dicek pre-test nya
                        if training class -> yang dicek post-test nya
                    */
                    $accumulatedFinalScore = 0;

                    switch ($classId->category_type) {
                        case "Training Class":
                            $testCategoryId = 3; // ngambil post test nya aja...
                            $tableAlias = 'f'; // ngambil persentase dari jadwal yang material type nya materi bukan tes (left join)
                            break;
                        case "Pre-test Class":
                            $testCategoryId = 1; // ngambil pre test nya untuk pre-class aja...
                            $tableAlias = 'b'; // ngambil persentase dari jadwal yang material type nya tes yang pre-test (langsung aja)
                            break;
                    }

                    $allTests = DB::table('t_class_session AS a')
                        ->selectRaw('
                                b.id,
                                b.material_id,
                                c.test_name,
                                e.test_score,
                                ' . $tableAlias . '.material_percentage,
                                CEILING((' . $tableAlias . '.material_percentage/100) * e.test_score) AS final_score
                            ')
                        ->leftJoin('t_session_material_schedule AS b', function ($join) {
                            $join->on('b.class_session_id', '=', 'a.id')
                                ->where('b.material_type', '=', 2);
                        })
                        ->leftJoin('tm_test AS c', 'c.id', '=', 'b.material_id')
                        ->leftJoin('tm_test_category AS d', 'd.id', '=', 'c.test_cat_id')
                        ->leftJoin('tr_emp_test AS e', 'e.test_sch_id', '=', 'b.id')
                        ->leftJoinSub(
                            DB::table('t_class_session AS a')
                                ->selectRaw('
                                        b.class_session_id,
                                        b.material_id,
                                        b.material_percentage,
                                        c.test_id
                                    ')
                                ->leftJoin('t_session_material_schedule AS b', function ($join) {
                                    $join->on('b.class_session_id', '=', 'a.id')
                                        ->where('b.material_type', '=', 1);
                                })
                                ->leftJoin('t_test_with_materials_list AS c', 'c.study_materials_id', '=', 'b.material_id')
                                ->leftJoin('tm_test AS d', 'd.id', '=', 'c.test_id')
                                ->leftJoin('tm_test_category AS e', 'e.id', '=', 'd.test_cat_id')
                                ->where('a.class_id', '=', $classId->class_id)
                                ->where('e.id', '=', $testCategoryId),
                            'f',
                            function ($join) {
                                $join->on('f.test_id', '=', 'b.material_id');
                            }
                        )
                        ->where('a.class_id', $classId->class_id)
                        ->where('d.id', $testCategoryId)
                        ->get();

                    foreach ($allTests as $test) {
                        $accumulatedFinalScore += $test->final_score;
                    }

                    // semua kelas standard nya 80
                    if ($accumulatedFinalScore >= 80) {
                        // update jadi lulus
                        DB::table('tr_enrollment AS a')
                            ->where('a.id', $tests->enrollment_id)
                            ->update([
                                'a.class_score' => $accumulatedFinalScore,
                                'a.enrollment_status_id' => 3
                            ]);
                    } else {
                        // update jadi gagal
                        DB::table('tr_enrollment AS a')
                            ->where('a.id', $tests->enrollment_id)
                            ->update([
                                'a.class_score' => $accumulatedFinalScore,
                                'a.enrollment_status_id' => 4
                            ]);
                    }
                } else {
                    // update jadi on-going
                    DB::table('tr_enrollment AS a')
                        ->where('a.id', $tests->enrollment_id)
                        ->update([
                            'a.enrollment_status_id' => 2
                        ]);
                }
            }
        }
        if ($insert_answer_action > 0) {
            return response()->json(['success' => true, 'message' => 'Test submitted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Test submission failed']);
        }
    }

    public function testResult($nip, $studentTestId, $role)
    {
        $testResultDetail = DB::table('tr_emp_test as a')
            ->select([
                'a.id as studentTestId',
                'a.emp_nip',
                'h.Employee_name',
                'a.time_started',
                'a.time_end',
                'b.id as materialId',
                'c.id as testid',
                'c.test_name',
                'c.test_desc',
                'c.pass_point',
                'e.id as questionId',
                'e.question',
                'e.points',
                'f.id as answerId',
                'f.answer',
                'f.correct_status',
                'g.id as studentAnswerId',
                'g.emp_test_id',
                'g.question_id',
                'g.answer_id',
                'i.class_id'
            ])
            ->leftJoin('t_session_material_schedule as b', 'b.id', '=', 'a.test_sch_id')
            ->leftJoin('tm_test as c', 'c.id', '=', 'b.material_id')
            ->leftJoin('test_has_questions as d', 'd.test_id', '=', 'c.id')
            ->leftJoin('tm_question_bank as e', 'e.id', '=', 'd.question_id')
            ->leftJoin('tm_answer_bank as f', 'f.question_id', '=', 'e.id')
            ->leftJoin('tr_emp_answer as g', function ($join) {
                $join->on('g.emp_test_id', '=', 'a.id')
                    ->on('g.question_id', '=', 'e.id')
                    ->on('g.answer_id', '=', 'f.id');
            })
            ->leftJoin(config('custom.employee_db') . '.emp_employee as h', 'h.nip', '=', 'a.emp_nip')
            ->leftJoin('t_class_session AS i', 'i.id', '=', 'b.class_session_id')
            ->where('a.emp_nip', '=', $nip)
            ->where('a.id', '=', $studentTestId)
            ->get();

        $testResult = DB::table('tr_emp_answer as a')
            ->selectRaw('
                GROUP_CONCAT(a.id) AS studentTestId,
                a.emp_test_id,
                GROUP_CONCAT(a.question_id) AS question_id,
                GROUP_CONCAT(a.answer_id) AS answer_id,
                GROUP_CONCAT(b.answer) AS answer,
                GROUP_CONCAT(b.correct_status) AS correct_status,
                GROUP_CONCAT(c.question) AS question,
                GROUP_CONCAT(c.points) AS points,
                SUM(c.points) AS max_point,
                COUNT(c.id) AS total_questions,
                SUM(CASE WHEN b.correct_status = 1 THEN 1 ELSE 0 END) AS total_correct,
                SUM(CASE WHEN b.correct_status = 0 THEN 1 ELSE 0 END) AS total_incorrect,
                SUM(CASE WHEN b.correct_status IS NULL THEN 1 ELSE 0 END) AS total_not_answered,
                SUM(CASE WHEN b.correct_status = 1 THEN c.points ELSE 0 END) AS result_point
            ')
            ->leftJoin('tm_answer_bank as b', 'b.id', '=', 'a.answer_id')
            ->leftJoin('tm_question_bank as c', 'c.id', '=', 'a.question_id')
            ->where('a.emp_test_id', '=', $studentTestId)
            ->groupBy('a.emp_test_id')
            ->first();

        return view('classrooms.testResult', compact('testResultDetail', 'testResult', 'role'));
    }
}
