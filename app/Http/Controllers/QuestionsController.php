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
            ->leftJoin('tm_answer_bank AS b', 'b.question_id', '=', 'a.id')
            ->leftJoin('tm_test AS c', 'c.id', '=', 'a.test_id')
            ->leftJoin('tm_test_category AS d', 'd.id', '=', 'c.test_cat_id')
            ->select('a.id', 'a.question', DB::raw('GROUP_CONCAT(b.answer SEPARATOR ", ") AS answer'), DB::raw('GROUP_CONCAT(b.correct_status SEPARATOR ", ") AS correct_status'), 'c.test_name', 'd.test_category', 'a.is_active')
            ->groupBy('a.id')
            ->orderBy('a.id', 'desc');
        if ($questions_kywd != null) {
            $any_params = [
                'a.question',
                'b.answer',
                'c.test_name',
                'd.test_category'
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
                'test_id' => 'required',
            ],
            [
                'question.required' => 'Pertanyaan belum terisi.',
                'test_id.required' => 'Nama tes belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $insert_question = [
            'test_id' => $request->test_id,
            'question' => $request->question,
            'is_active' => 1,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_question_action = DB::table('tm_question_bank')
            ->insertGetId($insert_question);
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
            ->where('a.id', $id)
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
                'test_id' => 'required',
            ],
            [
                'question.required' => 'Pertanyaan belum terisi.',
                'test_id.required' => 'Nama tes belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $update_question = [
            'test_id' => $request->test_id,
            'question' => $request->question,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_question_action = DB::table('tm_question_bank AS a')
            ->where('a.id', $id)
            ->update($update_question);
        // deleting answer record
        $delete_answer_action = DB::table('tm_answer_bank AS a')
            ->where('a.question_id', $id)
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
