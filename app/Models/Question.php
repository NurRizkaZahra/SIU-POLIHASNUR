<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
    'question_text',
    'answer_choices',
    'correct_answer',
    'score',
    'video_tutorial',
    'question_group_id'
];

protected $casts = [
    'answer_choices' => 'array'
];

public function group()
{
    return $this->belongsTo(QuestionGroup::class, 'question_group_id');
}

}
