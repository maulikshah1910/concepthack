<?php

namespace App\Imports;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportMCQ implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $dataRows)
    {
////        dd($dataRows->toArray());
//        $validation = Validator::make($dataRows->toArray(),[
//            '*.username' => 'required',
//            '*.question' => 'required',
//            '*.option1' => 'required',
//            '*.answer' => 'required',
//        ]);
//        if ($validation->fails()) {
////            return redirect(route('import'))->with('errors', $validation->getMessageBag()->toArray());
//            return response()->json([
//                'success' => false,
//                'message' => $validation->getMessageBag()->toArray()
//            ]);
//        }

        try {
            foreach ($dataRows as $dataRow) {
                $userName = $dataRow['username'];
                // find if user exists
                $userRow = User::where('username', $userName)->first();
                if (!$userRow instanceof User) {
                    // create a user if not exists
                    $userRow = User::factory()->create([
                        'username' => $userName
                    ]);
                    $userRow->save();
                }
                // check if the user has exam
                $userExam = Exam::where('user_id', $userRow->id)->first();
                if (!$userExam instanceof Exam) {
                    $userExam = Exam::create([
                        'user_id' => $userRow->id,
                        'exam_date' => Carbon::today()->format('Y-m-d'),
                    ]);
                }

                // check if the question exists or not..
                $options = [];
                for ($i = 1; $i <= 4; $i++) {
                    $option = 'option' . $i;
                    if (strlen($dataRow[$option]) > 0) {
                        $options[$option] = $dataRow[$option];
                    }
                }

                $question = Question::updateOrCreate([
                    'question_text' => $dataRow['question'],
                ], [
                    'options' => json_encode($options),
                    'correct_option' => $dataRow['answer'],
                    'score' => 1
                ]);

                ExamQuestion::updateOrCreate([
                    'exam_id' => $userExam->id,
                    'question_id' => $question->id,
                ], [
                    'answer' => $dataRow['answer'],
                ]);
            }
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.username' => 'required',
            '*.question' => 'required',
            '*.option1' => 'required',
            '*.answer' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.username.required' => 'Data required for field :attribute.',
            '*.question.required' => 'Data required for field :attribute.',
            '*.option1.required' => 'First option is required.',
            '*.answer.required' => 'Data required for field :attribute.',
        ];
    }
}
