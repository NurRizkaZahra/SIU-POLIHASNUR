<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'jalur_masuk',
        'pilihan_prodi',
        'status_ujian',
        'tanggal_ujian',
        'waktu_ujian',
        // Tambahkan kolom lain sesuai struktur tabel
    ];

    protected $casts = [
        'tanggal_ujian' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeBelumUjian($query)
    {
        return $query->where('status_ujian', 'belum');
    }

    public function scopeSelesaiUjian($query)
    {
        return $query->where('status_ujian', 'selesai');
    }
}
