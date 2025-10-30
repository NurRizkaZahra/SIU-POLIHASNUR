<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $table = 'exam_schedules';

    protected $fillable = [
        'wave_name',
        'start_date',
        'end_date',
        'participant_quota',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'participant_quota' => 'integer',
    ];

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute()
    {
        return Carbon::parse($this->start_date)->format('d M Y') . ' - ' .
               Carbon::parse($this->end_date)->format('d M Y');
    }

    /**
     * Get formatted date range for display (localized)
     */
    public function getFormattedDateRangeAttribute()
    {
        return Carbon::parse($this->start_date)->isoFormat('D MMMM Y') . ' - ' .
               Carbon::parse($this->end_date)->isoFormat('D MMMM Y');
    }

    /**
     * Check if the wave is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if the wave is full
     */
    public function isFull()
    {
        if (!$this->participant_quota) {
            return false;
        }

        // Hitung berdasarkan exam yang sudah approved
        $registeredCount = $this->exams()->where('status', 'approved')->count();
        return $registeredCount >= $this->participant_quota;
    }

    /**
     * Get remaining quota
     */
    public function getRemainingQuotaAttribute()
    {
        if (!$this->participant_quota) {
            return null;
        }

        // Hitung berdasarkan exam yang sudah approved
        $registeredCount = $this->exams()->where('status', 'approved')->count();
        return max(0, $this->participant_quota - $registeredCount);
    }

    /**
     * Get remaining quota (method version)
     */
    public function getRemainingQuota()
    {
        if (!$this->participant_quota) {
            return null;
        }

        $registeredCount = $this->exams()->where('status', 'approved')->count();
        return max(0, $this->participant_quota - $registeredCount);
    }

    /**
     * Scope for active waves
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for available waves (still open for registration)
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')
                     ->where('end_date', '>=', now());
    }

    /**
     * Relasi ke tabel exam (TAMBAHAN BARU)
     */
    public function exams()
    {
        return $this->hasMany(Exam::class, 'exam_schedule_id');
    }

    /**
     * Get approved exams only
     */
    public function approvedExams()
    {
        return $this->hasMany(Exam::class, 'exam_schedule_id')
                    ->where('status', 'approved');
    }

    /**
     * Get pending exams only
     */
    public function pendingExams()
    {
        return $this->hasMany(Exam::class, 'exam_schedule_id')
                    ->where('status', 'pending');
    }
}