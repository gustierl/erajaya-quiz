<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuizHeader;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $user;
    private $question;
    private $quiz;
    public function __construct()
    {
        $this->user = new User();
        $this->question = new Question();
        $this->quiz = new QuizHeader();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        SEOMeta::setTitle('Home');
        if (Auth::user()->hasrole('Admin')) {
            return view('home');
        } else {
            return view('home_user');
        }
    }
    public function homeScore()
    {
        if (Auth::user()->hasrole('User')) {
            $highScore = QuizHeader::where('email',Auth::user()->email)->max('total_score');
           
        }
        return response()->json(['highScore'=>$highScore]);
    }
    public function homeAdmin()
    {
        $totalUser = $this->user->totalUser();
        $totalQuestion = $this->question->totalQuestion();
        $totalQuiz = $this->quiz->totalQuiz();
        $rank = $this->quiz->getRank();
        return response()->json(['totalUser'=>$totalUser,'totalQuestion'=>$totalQuestion,'totalQuiz'=>$totalQuiz,'rank'=>$rank]);
    }
}
