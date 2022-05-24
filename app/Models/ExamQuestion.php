<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamQuestion extends Model
{
    use HasFactory;
//    use SoftDeletes;

    const ANS_IS_CORRECT = true;
    const ANS_IS_INCORRECT = false;

    protected $fillable = [
        'exam_id',
        'question_id',
        'answer',
        'is_correct'
    ];

    public function Exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }

    public function Question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}
