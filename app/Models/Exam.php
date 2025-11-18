<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';

    protected $fillable = [
        'user_id',
        'exam_schedule_id',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // ================= STATUS CONSTANTS =================
    const STATUS_PENDING      = 'pending';
    const STATUS_APPROVED     = 'approved';
    const STATUS_REJECTED     = 'rejected';
    const STATUS_IN_PROGRESS  = 'in_progress';
    const STATUS_COMPLETED    = 'completed';
    const STATUS_FINISHED     = 'finished';

    // ================= RELATIONSHIPS =================

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, 'exam_schedule_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(ExamAnswer::class);
    }

    // ================= ACCESSORS & HELPERS =================

    public function getStatusText()
    {
        return match ($this->status) {
            self::STATUS_PENDING      => 'Menunggu Verifikasi',
            self::STATUS_APPROVED     => 'Disetujui',
            self::STATUS_REJECTED     => 'Ditolak',
            self::STATUS_IN_PROGRESS  => 'Sedang Berlangsung',
            self::STATUS_COMPLETED    => 'Selesai Dikerjakan',
            self::STATUS_FINISHED     => 'Ujian Selesai',
            default                   => 'Tidak Diketahui',
        };
    }

    public function getFormattedTime()
    {
        $start = Carbon::parse($this->start_time)->format('H:i');
        $end   = Carbon::parse($this->end_time)->format('H:i');

        return $start . ' - ' . $end;
    }

    public function canBeCancelled()
    {
        return $this->status === self::STATUS_PENDING;
    }

    // ================= SCOPES =================

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeFinished($query)
    {
        return $query->where('status', self::STATUS_FINISHED);
    }

    // ================= BOOT METHOD =================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($exam) {
            if (empty($exam->status)) {
                $exam->status = self::STATUS_PENDING;
            }
        });
    }
}
