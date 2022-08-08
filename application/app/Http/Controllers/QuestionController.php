<?php

namespace App\Http\Controllers;

use App\Imports\QuestionImport;
use App\Models\Question;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    private $question;
    public function __construct()
    {
        $this->question = new Question();
    }
    public function index()
    {
        SEOTools::setTitle('Soal');
        return view('question');
    }
    public function store(Request $request)
    {
        $rule = [
            'question_name'=>['required'],
            'option_one'=>['required'],
            'option_two'=>['required'],
            'option_three'=>['required'],
            'answer'=>['required'],
            'score'=>['required','numeric','digits_between:1,2'],
            'status'=>['required']
        ];
        $message = [
            'question_name.required'=>'Pertanyaaan harus diisi',
            'option_one.required'=>'Pilihan Pertama harus diisi',
            'option_two.required'=>'Pilihan Kedua harus diisi',
            'option_three.required'=>'Pilihan ketiga harus diisi',
            'answer.required'=>'Pilih salah saju jawaban benar',
            'score.required'=>'Score harus diisi',
            'score.numeric'=>'Score harus angka',
            'score.digits_between'=>'Score harus 1-2 digit',
            'status.required'=>'Status harus diisi'

        ];
        $validator = Validator::make($request->all(),$rule,$message);
        if ($validator->passes()) {
            if ($request->question_code == null) {
                $checkScore = $this->question->checkScore();
            } else {
                $checkScore = $this->question->checkScoreUpdate($request->question_code,$request->score);
            }
            if ($checkScore >= 0 && $checkScore < 100) {
                if ($request->question_code == null) {
                    $data = [
                        'question_code'=>strtoupper(Str::random(8)),
                        'question_name'=>$request->question_name,
                        'option_one'=>$request->option_one,
                        'option_two'=>$request->option_two,
                        'option_three'=>$request->option_three,
                        'answer'=>$request->answer,
                        'score'=>$request->score,
                        'status'=>$request->status,
                    ];
                    $this->question->saveData($data);
                } else {
                    $data = [
                        'question_name'=>$request->question_name,
                        'option_one'=>$request->option_one,
                        'option_two'=>$request->option_two,
                        'option_three'=>$request->option_three,
                        'answer'=>$request->answer,
                        'score'=>$request->score,
                        'status'=>$request->status,
                    ];
                    $this->question->editData($request->question_code,$data);
                }
                return response()->json(['status'=>'success','message'=>'Data soal berhasil dibuat']);
            } else {
                return response()->json(['status'=>'failed','message'=>['score'=>['Score melebihi 100, Total Score saat ini : '.$checkScore]]]);
            }
        } else {
            return response()->json(['status'=>'failed','message'=>$validator->errors()]);
        }

    }
    public function data(Request $request)
    {
        $data = $this->question->getDataAll();
        return response()->json(['status'=>'success','data'=>$data]);
    }
    public function edit($question_code)
    {
        $data = $this->question->getDataSingle($question_code);
        return response()->json($data);
    }
    public function uploadExcel(Request $request)
    {
        $rule = [
            'file' => ['required','mimes:xls,xlsx,csv']
        ];
        $message = [
            'file.required' => 'File harus diisi',
            'file.mimes' => 'File harus berformat .xlsx / .CSV',
        ];
        $validator = Validator::make($request->all(),$rule,$message);
        if ($validator->passes()) {
            $excel = Excel::import(new QuestionImport,$request->file('file')->store('temp'));
            return  response()->json(['status'=>200,'message'=>$excel]);
        }else{
            return response()->json(['status'=>400,'message'=>$validator->errors()]);
        }
    }
}
