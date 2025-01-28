<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Events\AfterImport;

class TestsImport implements ToCollection
{
    protected $requestData;
    protected $insertedQuestionCount = 0;

    public function __construct(array $requestData)
    {
        // Ensure the request data is passed correctly
        $this->requestData = $requestData;

        // Debugging: Check if requestData is null
        if (is_null($this->requestData)) {
            // Optionally throw an exception or log it
            Log::error('Request data is null.');
        }
    }
    public function collection(Collection $rows)
    {
        $rows->shift();

        foreach ($rows as $row) {
            $insertData = [
                'question' => $row[0],
                'points' => $row[6],
                'created_by' => Auth::user()->id,
                'created_date' => Carbon::now(),
                'is_active' => 1
            ];
            $insertQuestion = DB::table('tm_question_bank')
                ->insertGetId($insertData);
            if ($insertQuestion != 0) {
                $this->insertedQuestionCount++;

                $testHasQuestionsData = [
                    'test_id' => $this->requestData['testId'],
                    'question_id' => $insertQuestion,
                ];
                $insertTestHasQuestions = DB::table('test_has_questions')
                    ->insert($testHasQuestionsData);

                // inserting option 1 (correct answer)
                if (!is_null($row[1])) {
                    $answerData = [
                        'question_id' => $insertQuestion,
                        'answer' => $row[1],
                        'correct_status' => 1,
                        'created_by' => Auth::user()->id,
                        'created_date' => Carbon::now(),
                    ];
                    $insertCorrectAnswer = DB::table('tm_answer_bank')
                        ->insert($answerData);
                }

                // inserting option 2
                if (!is_null($row[2])) {
                    $answerData2 = [
                        'question_id' => $insertQuestion,
                        'answer' => $row[2],
                        'correct_status' => 0,
                        'created_by' => Auth::user()->id,
                        'created_date' => Carbon::now(),
                    ];
                    $insertAnswer2 = DB::table('tm_answer_bank')
                        ->insert($answerData2);
                }

                // inserting option 3
                if (!is_null($row[3])) {
                    $answerData3 = [
                        'question_id' => $insertQuestion,
                        'answer' => $row[3],
                        'correct_status' => 0,
                        'created_by' => Auth::user()->id,
                        'created_date' => Carbon::now(),
                    ];
                    $insertAnswer3 = DB::table('tm_answer_bank')
                        ->insert($answerData3);
                }

                // inserting option 4
                if (!is_null($row[4])) {
                    $answerData4 = [
                        'question_id' => $insertQuestion,
                        'answer' => $row[4],
                        'correct_status' => 0,
                        'created_by' => Auth::user()->id,
                        'created_date' => Carbon::now(),
                    ];
                    $insertAnswer4 = DB::table('tm_answer_bank')
                        ->insert($answerData4);
                }

                // inserting option 5
                if (!is_null($row[5])) {
                    $answerData5 = [
                        'question_id' => $insertQuestion,
                        'answer' => $row[5],
                        'correct_status' => 0,
                        'created_by' => Auth::user()->id,
                        'created_date' => Carbon::now(),
                    ];
                    $insertAnswer5 = DB::table('tm_answer_bank')
                        ->insert($answerData5);
                }
            }
        }
    }

    public function getInsertedQuestionCount(): int
    {
        return $this->insertedQuestionCount;
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterImport::class => function (AfterImport $event) {
    //             session()->flash('import_message', "{$this->insertedQuestionCount} questions imported successfully.");
    //         }
    //     ];
    // }
}
