<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'exam_schedule_id',   // FIXED: dulunya 'jadwal_ujian_id'
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Exam Schedule
     */
    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class);
    }

    /**
     * Scope untuk notif belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', 0);
    }

    /**
     * Scope notif dibaca
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', 1);
    }

    /**
     * Scope notif berdasarkan tipe
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Buat notif approval jadwal ujian
     */
    public static function createExamApprovedNotification($userId, $examScheduleId)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'exam',  // FIXED: lebih konsisten
            'title' => 'Exam Request Approved',
            'message' => 'Your exam request has been approved.',
            'exam_schedule_id' => $examScheduleId,
            'is_read' => 0,
        ]);
    }

    /**
     * Notif info umum
     */
    public static function createInfoNotification($userId, $title, $message)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'info',
            'title' => $title,
            'message' => $message,
            'is_read' => 0,
        ]);
    }

    /**
     * Notif pengumuman
     */
    public static function createPengumumanNotification($userId, $title, $message)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'pengumuman',
            'title' => $title,
            'message' => $message,
            'is_read' => 0,
        ]);
    }
}
