<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class QuestionImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    private $question;
    public function __construct()
    {
        $this->question = new Question();
    }
    public function collection(Collection $collection)
    {
        foreach ($collection as $rows) {
            $data = [
                'question_code'=>strtoupper(Str::random(8)),
                'question_name'=>$rows[0],
                'option_one'=>$rows[1],
                'option_two'=>$rows[2],
                'option_three'=>$rows[3],
                'answer'=>$rows[4],
                'score'=>$rows[5],
                'status'=>$rows[6],
            ];
            $this->question->saveData($data);
        }
    }
    public function startRow(): int
    {
        return 2;
    }
}
