<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuestionsController extends Controller
{
    public function index($questions_kywd = null)
    {
        $questions = DB::table('tm_question_bank AS a')
            ->select('xx.id', 'xx.question', 'xx.points', 'xx.is_active', 'xx.answers', 'xx.correct_status', 'yy.test_name', 'yy.is_released')
            ->from(DB::raw('(SELECT
                            a.id, a.question, a.points, a.is_active, GROUP_CONCAT(b.answer SEPARATOR "; ") AS answers, GROUP_CONCAT(b.correct_status SEPARATOR ", ") AS correct_status
                            FROM tm_question_bank AS a
                            LEFT JOIN tm_answer_bank AS b ON b.question_id = a.id
                            GROUP BY a.id) AS xx'))
            ->leftJoin(DB::raw('(SELECT
                                a.id, GROUP_CONCAT(c.test_name SEPARATOR "; ") AS test_name, c.is_released
                                FROM tm_question_bank AS a
                                LEFT JOIN test_has_questions AS b ON b.question_id = a.id
                                LEFT JOIN tm_test AS c ON c.id = b.test_id
                                GROUP BY a.id) AS yy'), 'yy.id', '=', 'xx.id')
            ->orderBy('xx.id', 'DESC');
        if ($questions_kywd != null) {
            $any_params = [
                'xx.question',
                'xx.answers',
                'yy.test_name',
            ];
            $questions->whereAny($any_params, 'like', '%' . $questions_kywd . '%');
        }
        $questions = $questions->paginate(10);
        return view('questions.index', compact('questions', 'questions_kywd'));
    }

    public function create()
    {
        $tests = DB::table('tm_test AS a')
            ->get();
        return view('questions.create', compact('tests'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required',
                // 'test_id' => 'required',
                'points' => 'required',
            ],
            [
                'question.required' => 'Pertanyaan belum terisi.',
                // 'test_id.required' => 'Nama tes belum terisi.',
                'points.required' => 'Poin belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $insert_question = [
            'question' => $request->question,
            'points' => $request->points,
            'is_active' => 1,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_question_action = DB::table('tm_question_bank')
            ->insertGetId($insert_question);
        // masukkan jawaban
        if ($request->answers != null) {
            foreach ($request->answers as $key => $answer) {
                if ($request->answer_status == $key) {
                    $correct_status = 1;
                } else {
                    $correct_status = 0;
                }
                $insert_answer = [
                    'question_id' => $insert_question_action,
                    'answer' => $answer,
                    'correct_status' => $correct_status,
                    'created_by' => Auth::id(),
                    'created_date' => Carbon::now()
                ];
                $insert_answer_action = DB::table('tm_answer_bank')
                    ->insertGetId($insert_answer);
            }
        }
        // masukkan ke tes-tes yang dipilih
        if ($request->test_ids != null) {
            foreach ($request->test_ids as $key => $test_id) {
                $insert_test_has_questions = [
                    'test_id' => $test_id,
                    'question_id' => $insert_question_action
                ];
                DB::table('test_has_questions')
                    ->insert($insert_test_has_questions);
            }
        }
        if ($insert_question_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('questions')->with($status);
        }
    }

    public function edit($id)
    {
        $item = DB::table('tm_question_bank AS a')
            ->select('a.id', 'a.question', 'a.points', 'a.is_active')
            ->selectRaw(DB::raw('GROUP_CONCAT(c.id) AS test_ids, GROUP_CONCAT(c.test_name) AS test_names'))
            ->leftJoin('test_has_questions AS b', 'b.question_id', '=', 'a.id')
            ->leftJoin('tm_test AS c', 'c.id', '=', 'b.test_id')
            ->where('a.id', $id)
            ->groupBy('a.id')
            ->first();
        $tests = DB::table('tm_test AS a')
            ->get();
        $answers = DB::table('tm_answer_bank AS a')
            ->where('a.question_id', $id)
            ->get();
        return view('questions.edit', compact('item', 'tests', 'answers'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required',
                // 'test_id' => 'required',
                'points' => 'required',
            ],
            [
                'question.required' => 'Pertanyaan belum terisi.',
                // 'test_id.required' => 'Nama tes belum terisi.',
                'points.required' => 'Poin belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $update_question = [
            'question' => $request->question,
            'points' => $request->points,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_question_action = DB::table('tm_question_bank AS a')
            ->where('a.id', $id)
            ->update($update_question);
        // deleting answer record
        $delete_answer_action = DB::table('tm_answer_bank')
            ->where('question_id', $id)
            ->delete();
        if ($request->answers != null) {
            foreach ($request->answers as $key => $answer) {
                if ($request->answer_status == $key) {
                    $correct_status = 1;
                } else {
                    $correct_status = 0;
                }
                $update_answer = [
                    'question_id' => $id,
                    'answer' => $answer,
                    'correct_status' => $correct_status,
                    'created_by' => Auth::id(),
                    'created_date' => Carbon::now()
                ];
                $update_answer_action = DB::table('tm_answer_bank')
                    ->insertGetId($update_answer);
            }
        }
        // masukkan ke tes-tes yang dipilih
        $delete_test_has_question = DB::table('test_has_questions')
            ->where('question_id', $id)
            ->delete();
        if ($request->test_ids != null) {
            foreach ($request->test_ids as $key => $test_id) {
                $insert_test_has_questions = [
                    'test_id' => $test_id,
                    'question_id' => $id
                ];
                DB::table('test_has_questions')
                    ->insert($insert_test_has_questions);
            }
        }
        if ($update_question_action > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengedit data!'
            ];
            return redirect()->route('questions')->with($status);
        }
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_question_bank AS a')
            ->where('a.id', $request->id)
            ->update($delete_data);
        if ($update_affected > 0) {
            return $update_affected;
        } else {
            return 'failed to delete';
        }
    }

    public function recover(Request $request)
    {
        $recover_data = [
            'is_active' => 1,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_question_bank AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($update_affected > 0) {
            return $update_affected;
        } else {
            return 'failed to recover';
        }
    }
}
