<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class QuestionApiController extends Controller
{
    private $question;
    public function __construct()
    {
        $this->question = new Question();
    }
    public function index(Request $request)
    {
       $data = $this->question->getApiData();
       
       return response()->json(['status'=>'success','data'=>$data]);
    }
}
