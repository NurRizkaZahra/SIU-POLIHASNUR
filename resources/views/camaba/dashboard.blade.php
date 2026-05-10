@extends('layouts.app')

@section('title', 'SIU-POLIHASNUR - Beranda')
@section('page-title', 'BERANDA')

@push('styles')
<style>
    /*
     * CSS khusus halaman dashboard ini.
     * Base styles (hero, step, section) sudah ada di partials/styles.blade.php.
     * Di sini hanya override untuk kasus yang belum ditangani di base styles.
     */

    /*
     * Di tablet, hero section cukup pendek sehingga badge bisa terpotong.
     * Pastikan hero punya min-height agar badge tidak overflow.
     */
    @media (max-width: 1024px) and (min-width: 769px) {
        .hero-section {
            min-height: 420px;
        }

        /* Badge sedikit mengecil agar tidak memakan terlalu banyak ruang */
        .badge-kampus {
            top: 30px;
            right: 30px;
            font-size: 15px;
            padding: 15px 20px;
        }
    }

    /*
     * Mobile: hero berubah ke layout column, badge turun ke bawah konten.
     * Ini memastikan tidak ada overlap antara hero-content dan badge-kampus.
     */
    @media (max-width: 768px) {
        .hero-section {
            flex-direction: column;
            align-items: flex-start;
            height: auto;
            min-height: 0;
            padding-bottom: 30px;
        }

        /* Badge ikut aliran normal (bukan absolute) di mobile */
        .badge-kampus {
            position: relative;
            top: auto;
            right: auto;
            transform: none;
            margin-top: 20px;
            align-self: flex-start;
            font-size: 14px;
            padding: 12px 18px;
            /* Hapus rotasi agar tidak terlihat janggal di ruang sempit */
            transform: none;
        }

        /* Step list tidak perlu max-width di mobile, biarkan full width */
        .step-list {
            max-width: 100%;
        }
    }

    @media (max-width: 480px) {
        /* Tombol hero full-width di layar sangat kecil */
        .hero-buttons {
            flex-direction: column;
        }

        .hero-buttons .btn-primary,
        .hero-buttons .btn-secondary {
            width: 100%;
            text-align: center;
        }

        /* Step text lebih kecil sedikit agar tidak terpotong */
        .step-text {
            font-size: 13px;
        }

        .step-detail {
            font-size: 13px;
        }
    }
</style>
@endpush

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
                    <span class="step-text">1. Mengisi Formulir Pendaftaran</span>
                    <div class="chevron-icon">∨</div>
                </div>
                <div class="step-content">
                    <div class="step-detail">
                        Lengkapi data diri Anda meliputi:<br>
                        • Identitas pribadi (Nama, NIK, Tempat/Tanggal Lahir)<br>
                        • Alamat lengkap<br>
                        • Informasi orang tua/wali<br>
                        • Riwayat pendidikan<br>
                    </div>
                </div>
            </div>

            <div class="step-item" onclick="toggleStep(this)">
                <div class="step-header">
                    <span class="step-text">2. Melengkapi Berkas Persyaratan</span>
                    <div class="chevron-icon">∨</div>
                </div>
                <div class="step-content">
                    <div class="step-detail">
                        Berkas pendaftaran terbagi menjadi 2 kriteria yaitu:<br>
                        • Jalur Mandiri dan Berdikari<br>
                        • Jalur Beasiswa dan KIP<br>
                    </div>
                </div>
            </div>

            <div class="step-item" onclick="toggleStep(this)">
                <div class="step-header">
                    <span class="step-text">3. Mengikuti Tes</span>
                    <div class="chevron-icon">∨</div>
                </div>
                <div class="step-content">
                    <div class="step-detail">
                        Tes Masuk di Politeknik Hasnur terbagi menjadi 2 kriteria yaitu:<br>
                        • Tes Akademik (Pengetahuan Umum)<br>
                        • Tes Psikotes<br>
                    </div>
                </div>
            </div>

            <div class="step-item" onclick="toggleStep(this)">
                <div class="step-header">
                    <span class="step-text">4. Daftar Ulang</span>
                    <div class="chevron-icon">∨</div>
                </div>
                <div class="step-content">
                    <div class="step-detail">
                        Daftar ulang dilaksanakan di Kampus Politeknik Hasnur dengan membayarkan uang Rp 300.000 *(DP Seragam dan Jas Almamater)<br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection