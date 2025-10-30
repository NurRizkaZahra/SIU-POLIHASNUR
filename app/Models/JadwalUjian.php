<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Tambahkan ini
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // ✅ Tambahkan ini juga

class JadwalUjian extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ujian';

    protected $fillable = [
        'nama_gelombang',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota_peserta',
        'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'kuota_peserta' => 'integer'
    ];

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute()
    {
        return Carbon::parse($this->tanggal_mulai)->format('d M Y') . ' - ' . 
               Carbon::parse($this->tanggal_selesai)->format('d M Y');
    }

    /**
     * Get formatted date range for display (in Indonesian)
     */
    public function getFormattedDateRangeAttribute()
    {
        return Carbon::parse($this->tanggal_mulai)->isoFormat('D MMMM Y') . ' - ' . 
               Carbon::parse($this->tanggal_selesai)->isoFormat('D MMMM Y');
    }

    /**
     * Check if gelombang is active
     */
    public function isActive()
    {
        return $this->status === 'aktif';
    }

    /**
     * Check if gelombang is full
     */
    public function isFull()
    {
        if (!$this->kuota_peserta) {
            return false;
        }

        // Asumsi ada relasi ke tabel peserta
        // return $this->peserta()->count() >= $this->kuota_peserta;
        return false;
    }

    /**
     * Get remaining quota
     */
    public function getRemainingQuotaAttribute()
    {
        if (!$this->kuota_peserta) {
            return null;
        }

        // Asumsi ada relasi ke tabel peserta
        // $registered = $this->peserta()->count();
        $registered = 0;

        return $this->kuota_peserta - $registered;
    }

    /**
     * Scope untuk gelombang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk gelombang yang masih bisa didaftar
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'aktif')
                     ->where('tanggal_selesai', '>=', now());
    }

    /**
     * Relasi ke peserta (opsional, sesuaikan dengan struktur database kamu)
     */
    // public function peserta()
    // {
    //     return $this->hasMany(Peserta::class, 'jadwal_ujian_id');
    // }
}
