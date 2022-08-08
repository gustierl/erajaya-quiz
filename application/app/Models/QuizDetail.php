<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizDetail extends Model
{
    use HasFactory;
    protected $table    = 'quiz_detail';
    protected $fillable = [
        'quiz_code',
        'question_code',
        'answer',
        'score'
    ];
}
