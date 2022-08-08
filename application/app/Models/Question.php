<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table    = 'question';
    protected $fillable = [
        'question_code',
        'question_name',
        'option_one',
        'option_two',
        'option_three',
        'answer',
        'score',
        'status',
    ];

    public function saveData($data){
        Question::create($data);
        return true;
    }
    public function editData($question_code,$data){
        Question::where('question_code',$question_code)->update($data);
        return true;
    }
    public function checkScore()
    {
        $score = Question::where('status','AKTIF')->sum('score');
        return $score;
    }
    public function checkScoreUpdate($question_code,$newScore)
    {
        $totalScoreNow = Question::where('status','AKTIF')->sum('score');
        $getScoreQuestion = Question::where('question_code',$question_code)->first();
        $resultScore = ($totalScoreNow-$getScoreQuestion->score)+$newScore;
        return $resultScore;
    }
    public function getDataAll()
    {
        $data = Question::orderBy('updated_at','desc')->get();
        return $data;
    }
    public function getDataSingle($question_code)
    {
        $data = Question::where('question_code',$question_code)->first();
        return $data;
    }
    public function getApiData()
    {
        $data = Question::select('question_code','question_name','answer')->orderBy('updated_at','desc')->get();
        return $data;
    }
    public function totalQuestion()
    {
        $data = Question::orderBy('updated_at','desc')->count();
        return $data;
    }
}
