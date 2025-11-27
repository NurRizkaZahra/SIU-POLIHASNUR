<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'exam_answers';

    /**
     * Kolom yang bisa diisi mass assignment
     */
    protected $fillable = [
        'exam_id',
        'question_id',
        'selected_answer',
        'score',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'answered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Exam
     * Satu jawaban milik satu ujian
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Relasi ke Question
     * Satu jawaban untuk satu pertanyaan
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Cek apakah jawaban benar
     * 
     * @return bool
     */
    public function isCorrect()
    {
        return $this->selected_answer === $this->question->correct_answer;
    }

    /**
     * Scope: Filter berdasarkan exam
     */
    public function scopeForExam($query, $examId)
    {
        return $query->where('exam_id', $examId);
    }

    /**
     * Scope: Filter jawaban yang sudah dijawab
     */
    public function scopeAnswered($query)
    {
        return $query->whereNotNull('answered_at');
    }

    /**
     * Scope: Filter jawaban yang benar
     */
    public function scopeCorrect($query)
    {
        return $query->whereRaw('selected_answer = (SELECT correct_answer FROM questions WHERE questions.id = exam_answers.question_id)');
    }
}