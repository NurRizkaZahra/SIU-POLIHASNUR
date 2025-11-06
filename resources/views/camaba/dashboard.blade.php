@extends('layouts.app')

@section('title', 'SIU-POLIHASNUR - Beranda')
@section('page-title', 'BERANDA') 


@section('content')
    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Selamat Datang di<br>SIU (Sistem Informasi Ujian)<br>Politeknik Hasnur</h1>
            <p class="hero-subtitle">
                Sistem ini dirancang untuk mendukung proses evaluasi akademik di Politeknik Hasnur secara efisien, transparan, dan modern. Melalui platform ini, mahasiswa dapat mengikuti ujian secara online, aman, dan mudah diakses kapan saja.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('camaba.exam-schedule') }}" class="btn-primary">Pilih Jadwal</a>
                <a href="{{ route('camaba.registration') }}" class="btn-secondary">Lengkapi Data Diri</a>
            </div>
        </div>
        <div class="badge-kampus">
            KAMPUS<br>POLIHASNUR
        </div>
    </div>

    <div class="section-content">
        <div class="registration-title">ALUR PENDAFTARAN</div>

        <div class="step-list">
            <div class="step-item" onclick="toggleStep(this)">
                <div class="step-header">
                    <span class="step-text">1. Melengkapi Data Diri</span>
                    <div class="chevron-icon">∨</div>
                </div>
                <div class="step-content">
                    <div class="step-detail">
                        Lengkapi data diri Anda meliputi:<br>
                        • Identitas pribadi (Nama, NIK, Tempat/Tanggal Lahir)<br>
                        • Alamat lengkap<br>
                        • Informasi orang tua/wali<br>
                        • Riwayat pendidikan<br>
                        • Upload dokumen yang diperlukan
                    </div>
                </div>
            </div>

            <div class="step-item" onclick="toggleStep(this)">
                <div class="step-header">
                    <span class="step-text">2. Mengikuti Ujian Masuk</span>
                    <div class="chevron-icon">∨</div>
                </div>
                <div class="step-content">
                    <div class="step-detail">
                        Ikuti tahapan ujian masuk:<br>
                        • Cek jadwal ujian pada menu Jadwal Ujian<br>
                        • Pastikan perangkat dan koneksi internet stabil<br>
                        • Login 15 menit sebelum ujian dimulai<br>
                        • Ikuti petunjuk ujian dengan teliti<br>
                        • Tunggu pengumuman hasil ujian
                    </div>
                </div>
            </div>

            <div class="step-item" onclick="toggleStep(this)">
                <div class="step-header">
                    <span class="step-text">3. Daftar Ulang</span>
                    <div class="chevron-icon">∨</div>
                </div>
                <div class="step-content">
                    <div class="step-detail">
                        Proses daftar ulang bagi yang diterima:<br>
                        • Verifikasi pengumuman kelulusan<br>
                        • Download formulir daftar ulang<br>
                        • Lengkapi persyaratan administrasi<br>
                        • Lakukan pembayaran biaya pendidikan<br>
                        • Submit dokumen daftar ulang
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection