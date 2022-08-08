<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizHeader extends Model
{
    use HasFactory;
    protected $table    = 'quiz_header';
    protected $fillable = [
        'quiz_code',
        'email',
        'start_time',
        'end_time',
        'timeout',
        'total_score',
    ];
    public function totalQuiz()
    {
        $data = QuizHeader::count();
        return $data;
    }
    public function getRank()
    {
        $data = QuizHeader::select('quiz_header.*','users.name')
        ->leftJoin('users','quiz_header.email','=','users.email')
        ->groupBy('quiz_header.email')
        ->orderBy('total_score','desc')
        ->orderBy('created_at','desc')
        ->limit(10)
        ->get();
        return $data;
    }
    public function getDataAll()
    {
        $data =QuizHeader::select('quiz_header.*','users.name')
        ->leftJoin('users','quiz_header.email','=','users.email')
        ->orderBy('updated_at','desc')
        ->get();
        return $data;
    }
}
