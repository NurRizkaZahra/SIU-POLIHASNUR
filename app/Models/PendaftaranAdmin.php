<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranAdmin extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'pendaftaran';

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**
     * Kolom yang bisa diisi mass assignment
     */
    protected $fillable = [
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat_lengkap',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kode_pos',
        'no_hp',
        'email',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'no_hp_ortu',
        'asal_sekolah',
        'tahun_lulus',
        'jurusan_sekolah',
        'jalur_masuk',
        'pilihan_prodi',
        'foto',
        'ijazah',
        'kartu_keluarga',
        'status_pendaftaran',
        'status_ujian',
        'tanggal_ujian',
        'skor_ujian',
        'catatan_admin',
    ];

    /**
     * Kolom yang di-cast ke tipe data tertentu
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_ujian' => 'datetime',
        'tahun_lulus' => 'integer',
        'skor_ujian' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'status_pendaftaran' => 'pending',
        'status_ujian' => 'belum',
    ];

    /**
     * Accessor untuk nama lengkap dengan format title case
     */
    public function getNamaLengkapAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    /**
     * Accessor untuk format tanggal lahir
     */
    public function getTanggalLahirFormatAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->format('d F Y') : '-';
    }

    /**
     * Accessor untuk umur
     */
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : 0;
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pendaftaran', $status);
    }

    /**
     * Scope untuk filter berdasarkan prodi
     */
    public function scopeByProdi($query, $prodi)
    {
        return $query->where('pilihan_prodi', $prodi);
    }

    /**
     * Scope untuk filter berdasarkan jalur masuk
     */
    public function scopeByJalur($query, $jalur)
    {
        return $query->where('jalur_masuk', $jalur);
    }

    /**
     * Scope untuk pendaftar yang sudah ujian
     */
    public function scopeSudahUjian($query)
    {
        return $query->where('status_ujian', 'selesai');
    }

    /**
     * Scope untuk pendaftar yang belum ujian
     */
    public function scopeBelumUjian($query)
    {
        return $query->where('status_ujian', 'belum');
    }
}