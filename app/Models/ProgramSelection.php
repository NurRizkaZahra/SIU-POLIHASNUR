<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSelection extends Model
{
    use HasFactory;

    protected $table = 'program_selections';
    protected $primaryKey = 'id_selection';
    protected $fillable = [
        'user_id',
        'id_program_1',
        'id_program_2',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke program studi pertama
    public function program1()
    {
        return $this->belongsTo(StudyProgram::class, 'id_program_1');
    }

    // Relasi ke program studi kedua
    public function program2()
    {
        return $this->belongsTo(StudyProgram::class, 'id_program_2');
    }
}
