<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $table = 'study_programs';
    protected $primaryKey = 'id_program';
    protected $fillable = [
        'program_name',
    ];

    public function programSelections()
    {
        return $this->hasMany(ProgramSelection::class, 'id_program_1')
                    ->orWhere('id_program_2', $this->id_program);
    }
}
