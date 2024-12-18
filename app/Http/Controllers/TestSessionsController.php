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
            return redirect()->route('testSessions.questions', ['testScheduleId' => $existedTest->id, 'testId' => $testId]);
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
            return response()->json(['success' => true, 'message' => 'Test submitted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Test submission failed']);
        }
    }

    public function testResult($nip, $studentTestId)
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
            ->leftJoin('miegacoa_employees.emp_employee as h', 'h.nip', '=', 'a.emp_nip')
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
                SUM(CASE WHEN b.correct_status = 1 THEN 1 ELSE 0 END) AS total_correct,
                SUM(CASE WHEN b.correct_status = 1 THEN c.points ELSE 0 END) AS result_point
            ')
            ->leftJoin('tm_answer_bank as b', 'b.id', '=', 'a.answer_id')
            ->leftJoin('tm_question_bank as c', 'c.id', '=', 'b.question_id')
            ->where('a.emp_test_id', '=', $studentTestId)
            ->groupBy('a.emp_test_id')
            ->first();

        return view('classrooms.testResult', compact('testResultDetail', 'testResult'));
    }
}
