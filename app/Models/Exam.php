<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Exam extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'exams';

    protected $fillable = [
    'user_id',
    'exam_schedule_id',
    'started_at',
    'finished_at',
    'status',
    'score',
    ];

    protected $casts = [
    'started_at' => 'datetime',
    'finished_at' => 'datetime',
    ];


    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // ================= RELATIONSHIPS =================

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class, 'exam_schedule_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ================= ACCESSORS & HELPERS =================

    /**
     * Format status untuk tampilan
     */
    public function getStatusText()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Menunggu Verifikasi',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Format waktu ujian
     */
    public function getFormattedTime()
    {
        $start = Carbon::parse($this->start_time)->format('H:i');
        $end = Carbon::parse($this->end_time)->format('H:i');
        return $start . ' - ' . $end;
    }

    /**
     * Bisa dibatalkan? Hanya status pending
     */
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

    // ================= BOOT METHOD =================

    protected static function boot()
    {
        parent::boot();

        // Set default status saat create
        static::creating(function ($exam) {
            if (empty($exam->status)) {
                $exam->status = self::STATUS_PENDING;
            }
        });
    }
}
