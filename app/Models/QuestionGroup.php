<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionGroup extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
