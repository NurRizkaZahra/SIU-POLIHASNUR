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
        'location',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'participant_quota' => 'integer',
    ];

    // Constants untuk status
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_CLOSED = 'closed';

    // ================= RELATIONSHIPS =================

    public function exams()
    {
        return $this->hasMany(Exam::class, 'exam_schedule_id');
    }

    public function approvedExams()
    {
        return $this->exams()->where('status', Exam::STATUS_APPROVED);
    }

    public function pendingExams()
    {
        return $this->exams()->where('status', Exam::STATUS_PENDING);
    }

    public function rejectedExams()
    {
        return $this->exams()->where('status', Exam::STATUS_REJECTED);
    }

    // ================= ACCESSORS =================

    public function getDateRangeAttribute()
    {
        return Carbon::parse($this->start_date)->format('d M Y') . ' - ' .
               Carbon::parse($this->end_date)->format('d M Y');
    }

    public function getFormattedDateRangeAttribute()
    {
        return Carbon::parse($this->start_date)->isoFormat('D MMMM Y') . ' - ' .
               Carbon::parse($this->end_date)->isoFormat('D MMMM Y');
    }

    public function getRemainingQuota()
    {
        if (!$this->participant_quota) {
            return null;
        }
        return max(0, $this->participant_quota - $this->approvedExams()->count());
    }

    // ================= HELPER METHODS =================

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isClosed()
    {
        return $this->status === self::STATUS_CLOSED;
    }

    public function isFull()
    {
        if (!$this->participant_quota) return false;
        return $this->getRemainingQuota() <= 0;
    }

    public function hasAvailableQuota()
    {
        return $this->getRemainingQuota() > 0;
    }

    public function getApprovedCount()
    {
        return $this->approvedExams()->count();
    }

    public function getPendingCount()
    {
        return $this->pendingExams()->count();
    }

    public function getQuotaPercentage()
    {
        if (!$this->participant_quota || $this->participant_quota == 0) return 0;
        return round(($this->getApprovedCount() / $this->participant_quota) * 100, 2);
    }

    public function isRegistrationOpen()
    {
        $today = now()->startOfDay();
        return $this->isActive() && $this->end_date >= $today;
    }

    public function isPast()
    {
        return $this->end_date < now()->startOfDay();
    }

    public function isUpcoming()
    {
        return $this->start_date > now()->startOfDay();
    }

    public function getFormattedPeriod()
    {
        return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'badge-success',
            self::STATUS_INACTIVE => 'badge-warning',
            self::STATUS_CLOSED => 'badge-danger',
            default => 'badge-secondary',
        };
    }

    public function getStatusText()
    {
        return match($this->status) {
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_INACTIVE => 'Tidak Aktif',
            self::STATUS_CLOSED => 'Ditutup',
            default => 'Tidak Diketahui',
        };
    }

    public function getAvailabilityText()
    {
        if ($this->isFull()) return 'Kuota Penuh';
        if ($this->isPast()) return 'Sudah Ditutup';
        if ($this->isUpcoming()) return 'Belum Dibuka';
        if ($this->isRegistrationOpen()) return 'Pendaftaran Dibuka';
        return 'Tidak Tersedia';
    }

    public function hasUserApplied($userId)
    {
        return $this->exams()
                    ->where('user_id', $userId)
                    ->whereIn('status', [Exam::STATUS_PENDING, Exam::STATUS_APPROVED])
                    ->exists();
    }

    public function getUserExamStatus($userId)
    {
        return $this->exams()
                    ->where('user_id', $userId)
                    ->whereIn('status', [Exam::STATUS_PENDING, Exam::STATUS_APPROVED])
                    ->first();
    }

    // ================= SCOPES =================

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', self::STATUS_CLOSED);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
                     ->where('end_date', '>=', now()->startOfDay());
    }

    public function scopeCurrentlyActive($query)
    {
        $today = now()->startOfDay();
        return $query->where('status', self::STATUS_ACTIVE)
                     ->whereDate('start_date', '<=', $today)
                     ->whereDate('end_date', '>=', $today);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('start_date', '>', now()->startOfDay());
    }

    public function scopePast($query)
    {
        return $query->whereDate('end_date', '<', now()->startOfDay());
    }

    public function scopeHasQuota($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('participant_quota')
              ->orWhereColumn('participant_quota', '>', function ($subQuery) {
                  $subQuery->selectRaw('COUNT(*)')
                           ->from('exam')
                           ->whereColumn('exam.exam_schedule_id', 'exam_schedules.id')
                           ->where('exam.status', Exam::STATUS_APPROVED);
              });
        });
    }

    // ================= BOOT METHOD =================

    protected static function boot()
    {
        parent::boot();

        // Set default status saat create
        static::creating(function ($examSchedule) {
            if (empty($examSchedule->status)) {
                $examSchedule->status = self::STATUS_ACTIVE;
            }
        });

        // Auto close jika tanggal sudah lewat
        static::updating(function ($examSchedule) {
            if ($examSchedule->end_date < now()->startOfDay() && $examSchedule->status === self::STATUS_ACTIVE) {
                $examSchedule->status = self::STATUS_CLOSED;
            }
        });
    }
}
