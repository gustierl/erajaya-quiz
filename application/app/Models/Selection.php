<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    use HasFactory;
    protected $table    = 'selection';
    protected $fillable = [
        'selection_code',
        'question_code',
        'selection_name'
    ];
}
