<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exam';

    protected $fillable = [
        'user_id',
        'exam_schedule_id',
        'status',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relasi ke User (Camaba yang request)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Exam Schedule
    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, 'exam_schedule_id');
    }

    // Scope untuk filter pending exams
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope untuk filter approved exams
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}