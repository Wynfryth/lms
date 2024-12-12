<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestSessionsController extends Controller
{
    public function index($testId)
    {
        $test = DB::table('tm_test AS a')
            ->select(
                'a.id AS testId',
                'a.test_name',
                'a.test_desc',
                'a.estimated_time',
            )
            ->selectRaw('COUNT(c.id) AS total_questions, GROUP_CONCAT(c.id) AS questionId, SUM(c.points) AS total_points')
            ->leftJoin('test_has_questions AS b', 'a.id', '=', 'b.test_id')
            ->leftJoin('tm_question_bank AS c', 'b.question_id', '=', 'c.id')
            ->where('a.id', $testId)
            ->first();
        return view('classrooms.testSession', compact('test'));
    }

    public function question($testId, $questionId, $questionOrder)
    {
        $question = DB::table('tm_question_bank AS a')
            ->select(
                'a.id AS questionId',
                'a.question',
                'a.points',
                'b.id AS answerId',
                'b.answer',
            )
            ->leftJoin('tm_answer_bank AS b', 'a.id', '=', 'b.question_id')
            ->where('a.id', $questionId)
            ->get();
        return view('classrooms.question', compact('question'));
    }
}
