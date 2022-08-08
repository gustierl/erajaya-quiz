<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuizDetail;
use App\Models\QuizHeader;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuizController extends Controller
{
    private $user;
    private $question;
    private $quiz_header;
    private $quiz_detail;
    public function __construct()
    {
        $this->user = new User();
        $this->question = new Question();
        $this->quiz_header = new QuizHeader();
        $this->quiz_detail = new QuizDetail();
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $data = $this->quiz_header->getDataAll();
        if($request->ajax())
            {
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<button class="btn btn-sm btn-icon btn-outline-dark mr-1 view-data" data-toggle="tooltip" title="Edit"  data-id="'.$row->quiz_code.'" data-original-title="view"><i class="ri-eye-line"></i></button> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
        return view('list_quiz')->with(['data'=>$data]);
    }
    public function show($id)
    {
        $data = QuizDetail::select('quiz_detail.*','question.answer as right_answer','question.question_name','question.option_one','question.option_two','question.option_three')
        ->leftJoin('question','quiz_detail.question_code','=','question.question_code')
        ->where('quiz_code',$id)
        ->get();

        $dataHeader = QuizHeader::select('quiz_header.total_score','users.name')
        ->leftJoin('users','quiz_header.email','=','users.email')
        ->where('quiz_code',$id)
        ->first();
        return view('quiz_detail')->with(['data'=>$data,'name'=>$dataHeader->name,'total_score'=>$dataHeader->total_score]);
    }
}
