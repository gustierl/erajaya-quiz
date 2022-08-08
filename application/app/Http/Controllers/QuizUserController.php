<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuizDetail;
use App\Models\QuizHeader;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class QuizUserController extends Controller
{
    private $quizHeader;
    private $quizDetail;
    public function __construct()
    {
        $this->quizHeader = new QuizHeader();
        $this->quizDetail = new QuizDetail();
    }
    public function index($id)
    {

        $checkQuiz = QuizHeader::select('quiz_code','timeout')->where('email',Auth::user()->email)->where('quiz_code',$id);
        if ($checkQuiz->count() == 0) {
           return abort(403);
        } else {
            $data = $checkQuiz->first();
            $timeout = date('M j, Y H:i:s',strtotime($data->timeout));
            return view('quiz')->with(['quiz_code'=>$id,'timeout'=>$timeout]);
        }
    }
    public function createNewQuiz()
    {
        $createIdQuiz = strtoupper(Str::random(16));
        $startTime = NOW();
        $timeout = date('Y-m-d H:i:s', strtotime('+15 minute', strtotime($startTime)));
        QuizHeader::create([
            'quiz_code'=>$createIdQuiz,
            'email'=>Auth::user()->email,
            'start_time'=>$startTime,
            'timeout'=>$timeout,
            'total_score'=>0
        ]);
        return response()->json(['id'=>$createIdQuiz]);
    }
    public function load(Request $request)
    {
        $quizCode = $request->quiz_code;
        $checkTimeout = $this->checkTimeOut($quizCode);
        if ($checkTimeout['status'] != 'expired') {
            $checkQuizDetail = QuizDetail::select('quiz_detail.quiz_code','quiz_header.email','quiz_detail.question_code')
            ->leftJoin('quiz_header','quiz_detail.quiz_code','=','quiz_header.quiz_code')
            ->where('quiz_header.email', Auth::user()->email);
            if ($checkQuizDetail->count() == 0) {
                $dataQuestion = Question::select('question_code','question_name','option_one','option_two','option_three')
                ->inRandomOrder()
                ->first();
                $question =  $this->formatQuestion($dataQuestion);
                $data = ['question_list'=>$question,'status'=>'next'];
    
            } else {
                $total_score = QuizHeader::select('total_score')->where('quiz_code',$quizCode)->where('email',Auth::user()->email)->first();
                $idQuizOrder = $checkQuizDetail->where('quiz_detail.quiz_code',$quizCode)->get()->pluck('question_code')->toArray();
                $checkQuestion = Question::select('question_code','question_name','option_one','option_two','option_three')
                ->inRandomOrder()
                ->whereNotIn('question_code',$idQuizOrder);
                $checkTimeout = $this->checkTimeOut($quizCode);
                    if ($checkQuestion->count() == 0) {
                        QuizHeader::where('email',Auth::user()->email)->where('quiz_code',$quizCode)->update(['end_time'=>now()]);
                        $finish = $this->formatFinish($total_score->total_score);
                        $data = ['question_list'=>$finish,'status'=>'finish'];
        
                    }else{
                        if ($checkTimeout['status'] != 'expired') {
                            $dataQuestion = $checkQuestion->first();
                            $question = $this->formatQuestion($dataQuestion);
                            $data = ['question_list'=>$question,'status'=>'next'];
                         }else{
                            $finish = $this->formatFinish($total_score->total_score);
                            $data = ['question_list'=>$finish,'status'=>'finish'];
                        }
                        
                    }
               
               
            }
        } else {
            $finish = $this->formatFinish($checkTimeout['total_score']);
            $data = ['question_list'=>$finish,'status'=>'finish'];
        }
        return response()->json($data);

    }
    
    public function checkTimeOut($quizCode)
    {
        $checkQuiz = QuizHeader::select('quiz_code','timeout','total_score')->where('email',Auth::user()->email)->where('quiz_code',$quizCode);
        $data = $checkQuiz->first();
        $datetimnow = strtotime(date('H:i:s',strtotime(now())));
        $timeout = strtotime(date('H:i:s',strtotime($data->timeout)));
        if ($datetimnow > $timeout) {
            $checkQuiz->update([
                'end_time'=>NOW()
            ]);
            $status = 'expired';
            $score = $data->total_score;
        } else {
            $status = 'no expired';
            $score = $data->total_score;
        }
        
        $data = ['status'=>$status,'total_score'=>$score];
        return $data;
      
    }
    public function store(Request $request)
    {
        $rule = [
            'quiz_code'=>['required'],
            'question_code'=>['required'],
            'answer'=>['required']
        ];
        $message = [
            'quiz_code.required'=>'Quiz Code kosong',
            'question_code.required'=>'Question Code kosong',
            'answer.required'=>'Pilih salah satu jawaban'
        ];
        $validator = Validator::make($request->all(),$rule,$message);
        if ($validator->passes()) {
            $checkQuizCode = QuizHeader::where('quiz_code',$request->quiz_code)->where('email',Auth::user()->email)->count();
            $checkQuestionCode = Question::where('question_code',$request->question_code)->count();
            if($checkQuizCode == 0){
                return response()->json(['status'=>'failed','message'=>['answer'=>['Quiz Code tidak terdeteksi']]]);
            }
            if($checkQuestionCode == 0){
                return response()->json(['status'=>'failed','message'=>['answer'=>['Quiz Code tidak terdeteksi']]]);
            }
            $dataQuestion = Question::select('score','answer')->where('question_code',$request->question_code)->first();
            if ($request->answer == $dataQuestion->answer) {
                $score = $dataQuestion->score;
            } else {
               $score = 0;
            }
            QuizDetail::create([
                'quiz_code'=>$request->quiz_code,
                'question_code'=>$request->question_code,
                'answer'=>$request->answer,
                'score'=>$score
            ]);
            $quizHeader = QuizDetail::leftJoin('quiz_header','quiz_detail.quiz_code','=','quiz_header.quiz_code')
            ->where('quiz_detail.quiz_code',$request->quiz_code)
            ->where('quiz_header.email',Auth::user()->email);
            $quizHeader->update(['total_score'=>$quizHeader->sum('quiz_detail.score')]);
            return response()->json(['status'=>'success','message'=>'Data Berhasil Disimpan']);
        } else {
            return response()->json(['status'=>'failed','message'=>$validator->errors()]);
        }
    }
    public function formatQuestion($dataQuestion){
        $question = '<div class="form-group">
        <h5>'.$dataQuestion->question_name.'</h5>
    </div>
    <input type="hidden" name="question_code" value="'.$dataQuestion->question_code.'" id="question_code">
    <div class="form-group">
        <small for="" class="control-label">Jawaban :</small><br><br>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="answer" value="'.$dataQuestion->option_one.'" id="optionRadios1">
            <label for="optionRadios1">'.$dataQuestion->option_one.'</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="answer" value="'.$dataQuestion->option_two.'" id="optionRadios2">
            <label for="optionRadios2">'.$dataQuestion->option_two.'</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="answer" value="'.$dataQuestion->option_three.'" id="optionRadios3">
            <label for="optionRadios3">'.$dataQuestion->option_three.'</label>
        </div>
    </div>';
    return $question;
    }
    public function formatFinish($toalScore)
    {
        $finish = '<div class="text-center">
        <h1 style="font-size:50pt;" class="text-success"><i  class="ri-checkbox-circle-line" ></i> </h1>
        <h1> Quiz telah selesai </h5> 
        <h4> Score Anda : <span style="font-size:24pt;">'.$toalScore.'</span> </h4> 
        </div>';
        return $finish;
    }
}
