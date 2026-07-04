@extends('layouts.app')

@section('title', 'SIU-POLIHASNUR - Daftar Ujian')
@section('page-title', 'UJIAN')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .exam-list-wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 80vh;
            padding: 40px 20px 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .page-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-header h2 {
            font-size: 22px;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0 0 6px;
        }

        .page-header p {
            font-size: 13.5px;
            color: #64748b;
            margin: 0;
        }

        /* Student Bar */
        .student-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 14px 20px;
            max-width: 580px;
            width: 100%;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            border: 2px solid #e2e8f0;
        }

        .student-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        .student-details {
            flex: 1;
        }

        .student-name {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 2px;
        }

        .student-wave {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }

        .student-date {
            font-size: 12px;
            font-weight: 600;
            color: #1e3a8a;
            background: #eff6ff;
            padding: 5px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }

        /* Container */
        .exam-container {
            width: 100%;
            max-width: 580px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* Group Card */
        .group-card {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .group-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px 22px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .group-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .icon-blue {
            background: #dbeafe;
        }

        .icon-indigo {
            background: #e0e7ff;
        }

        .group-meta {
            flex: 1;
        }

        .group-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 3px;
        }

        .group-sub {
            font-size: 12px;
            color: #94a3b8;
            margin: 0;
        }

        /* Test row */
        .test-list {
            padding: 6px 0;
        }

        .test-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 22px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s;
        }

        .test-item:last-child {
            border-bottom: none;
        }

        .test-item:hover {
            background: #f8fafc;
        }

        .test-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #1e3a8a;
            flex-shrink: 0;
        }

        .test-info {
            flex: 1;
        }

        .test-name {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        /* Tombol Kerjakan */
        .btn-kerjakan {
            background: #1e3a8a;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 9px 22px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
            box-shadow: 0 3px 10px rgba(30, 58, 138, 0.25);
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-decoration: none;
            display: inline-block;
        }

        .btn-kerjakan:hover {
            background: #152d6b;
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(30, 58, 138, 0.4);
            color: white;
        }

        /* Info Note — lebar mengikuti .exam-container (width: 100%) */
        .info-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 14px;
            padding: 14px 18px;
            width: 100%;
            box-sizing: border-box;
        }

        .info-note p {
            font-size: 12.5px;
            color: #1e40af;
            margin: 0;
            line-height: 1.6;
        }

        /* Alerts */
        .alert {
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 13.5px;
            max-width: 580px;
            width: 100%;
        }

        .alert-danger {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-info {
            background: #dbeafe;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        /* =========================
       GLOBAL
    ========================= */
        * {
            box-sizing: border-box;
        }

        /* =========================
       TABLET
    ========================= */
        @media (max-width: 1024px) {

            .exam-list-wrapper {
                padding: 30px 20px 50px;
            }

            .exam-container,
            .student-bar,
            .alert {
                max-width: 100%;
            }
        }

        /* =========================
       MOBILE
    ========================= */
        @media (max-width: 768px) {

            .exam-list-wrapper {
                padding: 24px 14px 40px;
            }

            .page-header {
                margin-bottom: 22px;
            }

            .page-header h2 {
                font-size: 20px;
            }

            .page-header p {
                font-size: 12px;
                line-height: 1.5;
            }

            .student-bar {
                padding: 14px;
                border-radius: 14px;
                gap: 10px;
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .student-avatar {
                width: 36px;
                height: 36px;
            }

            .student-name {
                font-size: 13px;
            }

            .student-wave {
                font-size: 11px;
            }

            .student-date {
                margin-left: auto;
                font-size: 11px;
                padding: 4px 10px;
            }

            .group-card {
                border-radius: 16px;
            }

            .group-header {
                padding: 14px 16px;
                gap: 12px;
            }

            .group-icon {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                font-size: 18px;
            }

            .group-title {
                font-size: 14px;
            }

            .group-sub {
                font-size: 11px;
                line-height: 1.4;
            }

            .test-item {
                padding: 14px 16px;
                gap: 10px;
                align-items: center;
            }

            .test-num {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }

            .test-name {
                font-size: 13px;
                line-height: 1.4;
            }

            .btn-kerjakan {
                padding: 8px 14px;
                font-size: 11px;
                border-radius: 999px;
            }

            .info-note {
                padding: 12px 14px;
                border-radius: 12px;
            }

            .info-note p {
                font-size: 11.5px;
                line-height: 1.6;
            }

            .alert {
                font-size: 12px;
                padding: 10px 14px;
            }
        }

        /* =========================
       SMALL MOBILE
    ========================= */
        @media (max-width: 480px) {

            .exam-list-wrapper {
                padding: 18px 10px 30px;
            }

            .page-header h2 {
                font-size: 18px;
            }

            .page-header p {
                font-size: 11px;
            }

            .student-bar {
                padding: 12px;
            }

            .student-avatar {
                width: 34px;
                height: 34px;
            }

            .student-name {
                font-size: 12px;
            }

            .student-wave {
                font-size: 10px;
            }

            .student-date {
                font-size: 10px;
            }

            .group-header {
                padding: 12px 14px;
            }

            .group-title {
                font-size: 13px;
            }

            .group-sub {
                font-size: 10px;
            }

            .test-item {
                padding: 12px 14px;
            }

            .test-name {
                font-size: 12px;
            }

            .btn-kerjakan {
                font-size: 10px;
                padding: 7px 12px;
            }

            .info-note p {
                font-size: 10.5px;
            }
        }
    </style>

    <div class="exam-list-wrapper">

        {{-- Alerts --}}
        @if (session('error'))
            <div class="alert alert-danger">⚠️ {{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if (session('info'))
            <div class="alert alert-info">ℹ️ {{ session('info') }}</div>
        @endif

        {{-- Page Header --}}
        <div class="page-header">
            <h2>Daftar Ujian</h2>
            <p>Pilih kelompok ujian yang ingin dikerjakan, lalu klik <strong>Kerjakan</strong>.</p>
        </div>

        {{-- Student Bar --}}
        <div class="student-bar">
            <div class="student-avatar">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}"
                    alt="Avatar" class="student-avatar-img">
            </div>
            <div class="student-details">
                <p class="student-name">{{ Auth::user()->name }}</p>
                <p class="student-wave">{{ optional($schedules->first())->wave_name ?? 'Gelombang tidak diketahui' }}</p>
            </div>
            <span class="student-date">{{ date('d/m/Y') }}</span>
        </div>

        <div class="exam-container">

            {{-- ═══════════════════════════
             KELOMPOK 1: PENGETAHUAN UMUM
        ════════════════════════════ --}}
            <div class="group-card">
                <div class="group-header">
                    <div class="group-icon icon-blue">📚</div>
                    <div class="group-meta">
                        <p class="group-title">Pengetahuan Umum</p>
                        <p class="group-sub">Pilihan ganda &nbsp;</p>
                    </div>
                </div>
                <div class="test-list">
                    <div class="test-item">
                        <div class="test-num">1</div>
                        <div class="test-info">
                            <p class="test-name">Tes Pengetahuan Umum</p>
                        </div>
                        <a href="{{ route('camaba.exam.start', ['group' => 'pu']) }}" class="btn-kerjakan">
                            Kerjakan →
                        </a>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════
             KELOMPOK 2: PSIKOTES
        ════════════════════════════ --}}
            <div class="group-card">
                <div class="group-header">
                    <div class="group-icon icon-indigo">🧠</div>
                    <div class="group-meta">
                        <p class="group-title">Psikotes</p>
                        <p class="group-sub">
                            {{ $questionGroups->count() ?: 4 }} sub-tes
                            &nbsp;·&nbsp; Tersedia video tutorial tiap tes
                        </p>
                    </div>
                </div>
                <div class="test-list">
                    @if ($questionGroups->count() > 0)
                        @foreach ($questionGroups as $i => $grp)
                            <div class="test-item">
                                <div class="test-num">{{ $i + 1 }}</div>
                                <div class="test-info">
                                    <p class="test-name">{{ $grp->name ?? 'Psikotes Tes ' . ($i + 1) }}</p>
                                </div>
                                <a href="{{ route('camaba.exam.start', ['group' => 'psi', 'tes' => $i + 1]) }}"
                                    class="btn-kerjakan">
                                    Kerjakan →
                                </a>
                            </div>
                        @endforeach
                    @else
                        @foreach ([1, 2, 3, 4] as $num)
                            <div class="test-item">
                                <div class="test-num">{{ $num }}</div>
                                <div class="test-info">
                                    <p class="test-name">Psikotes Tes {{ $num }}</p>
                                </div>
                                <a href="{{ route('camaba.exam.start', ['group' => 'psi', 'tes' => $num]) }}"
                                    class="btn-kerjakan">
                                    Kerjakan →
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Info Note --}}
            <div class="info-note">
                <span style="font-size:16px; flex-shrink:0; margin-top:1px;">ℹ️</span>
                <p>
                    Ujian <strong>harus dikerjakan secara berurutan</strong>. Setelah satu tes selesai,
                    tes berikutnya akan terbuka secara otomatis. Pastikan koneksi internet Anda stabil
                    sebelum memulai setiap tes.
                </p>
            </div>

        </div>
    </div>
@endsection
