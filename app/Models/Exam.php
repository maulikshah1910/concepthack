<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
//    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'exam_date',
        'score',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Questions()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_id', 'id');
    }
}
