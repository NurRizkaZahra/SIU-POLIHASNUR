@extends('layouts.app')

@section('title', 'Ujian')
@section('page-title', 'UJIAN')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .exam-wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
            padding: 40px 20px;
            min-height: 70vh;
        }

        .exam-card {
            background: #ffffff;
            border: 2.5px solid #1e3a8a;
            border-radius: 25px;
            padding: 50px 60px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        /* Tombol kembali */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            margin-bottom: 24px;
            transition: color 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .back-link:hover {
            color: #1e3a8a;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        /* Badge nama tes */
        .test-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 12.5px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Profile icon */
        .profile-icon {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 20px;
            border: 3px solid #1e3a8a;
            flex-shrink: 0;
        }

        .profile-icon-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        /* HAPUS rule ini */
        /* .profile-icon svg { ... } */

        /* ══════════════════════════════════════════
           VIDEO TUTORIAL — hanya tampil jika $isPsikotes
        ══════════════════════════════════════════ */
        .video-section {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
            margin-bottom: 28px;
        }

        .video-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
        }

        .video-header-icon {
            width: 34px;
            height: 34px;
            background: #fee2e2;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .video-header-text p {
            margin: 0;
        }

        .vt-title {
            font-size: 13.5px;
            font-weight: 700;
            color: #1e293b;
        }

        .vt-sub {
            font-size: 11.5px;
            color: #94a3b8;
        }

        .video-warning {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            background: #fef3c7;
            border-bottom: 1px solid #fde68a;
            font-size: 12px;
            color: #92400e;
            font-weight: 500;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* 16:9 embed */
        .video-embed {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            background: #0f172a;
        }

        .video-embed iframe,
        .video-embed video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .video-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #64748b;
            font-size: 13px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .video-placeholder .play-circle {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        /* Checkbox sudah tonton */
        .watched-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-top: 1px solid #e2e8f0;
            background: #fff;
            cursor: pointer;
            user-select: none;
        }

        .watched-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #1e3a8a;
            cursor: pointer;
            flex-shrink: 0;
        }

        .watched-row label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Hint teks */
        .btn-hint {
            font-size: 12px;
            color: #ef4444;
            text-align: center;
            margin-top: -28px;
            margin-bottom: 28px;
            display: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-hint.show {
            display: block;
        }

        /* ══════════════════════════════════════════
           START BUTTON & FORM FIELDS
           Sama persis dengan blade lama
        ══════════════════════════════════════════ */
        .start-button {
            background: #1e3a8a;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 14px 45px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 35px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
            display: block;
            width: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .start-button:hover:not(:disabled) {
            background: #152d6b;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.45);
        }

        .start-button:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .form-input {
            width: 100%;
            padding: 13px 20px;
            border: 2px solid #1e3a8a;
            border-radius: 50px;
            font-size: 14px;
            color: #1e3a8a;
            background: #f8fafc;
            text-align: left;
            font-weight: 500;
            transition: all 0.3s;
            cursor: not-allowed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-sizing: border-box;
        }

        /* Alerts — sama persis dengan blade lama */
        .alert {
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
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

        .continue-link {
            display: inline-block;
            margin-top: 15px;
            color: #1e3a8a;
            font-weight: 600;
            text-decoration: underline;
        }

        .continue-link:hover {
            color: #152d6b;
        }

        /* =========================
       GLOBAL
    ========================= */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            overflow-x: hidden;
        }

        /* =========================
       TABLET
    ========================= */
        @media (max-width: 1024px) {

            .exam-wrapper {
                padding: 30px 18px;
            }

            .exam-card {
                max-width: 100%;
                padding: 40px 40px;
            }
        }

        /* =========================
       MOBILE
    ========================= */
        @media (max-width: 768px) {

            .exam-wrapper {
                padding: 20px 14px;
            }

            .exam-card {
                padding: 30px 22px;
                border-radius: 20px;
            }

            /* Top row */
            .top-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
                margin-bottom: 20px;
            }

            .back-link {
                font-size: 12px;
                margin-bottom: 0;
            }

            .test-badge {
                font-size: 11px;
                padding: 5px 12px;
                margin-bottom: 0;
            }

            /* Profile */
            .profile-icon {
                width: 50px;
                height: 50px;
                margin-bottom: 18px;
            }

            .profile-icon svg {
                width: 24px;
                height: 24px;
            }

            /* Video */
            .video-section {
                border-radius: 14px;
                margin-bottom: 24px;
            }

            .video-header {
                padding: 12px 14px;
                gap: 8px;
            }

            .video-header-icon {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }

            .vt-title {
                font-size: 12.5px;
            }

            .vt-sub {
                font-size: 10.5px;
            }

            .video-warning {
                font-size: 11px;
                padding: 8px 14px;
                line-height: 1.5;
            }

            .watched-row {
                padding: 10px 14px;
            }

            .watched-row label {
                font-size: 12px;
                line-height: 1.5;
            }

            /* Button */
            .start-button {
                padding: 13px 20px;
                font-size: 14px;
                margin-bottom: 28px;
            }

            .btn-hint {
                font-size: 11px;
                line-height: 1.5;
                margin-top: -20px;
                margin-bottom: 22px;
            }

            /* Form */
            .form-group {
                margin-bottom: 18px;
            }

            .form-label {
                font-size: 12px;
            }

            .form-input {
                padding: 12px 16px;
                font-size: 13px;
            }

            /* Alert */
            .alert {
                font-size: 12px;
                padding: 10px 14px;
            }
        }

        /* =========================
       SMALL MOBILE
    ========================= */
        @media (max-width: 480px) {

            .exam-wrapper {
                padding: 14px 10px;
            }

            .exam-card {
                padding: 24px 16px;
                border-radius: 16px;
            }

            .back-link {
                font-size: 11px;
            }

            .test-badge {
                font-size: 10px;
                padding: 4px 10px;
            }

            .profile-icon {
                width: 46px;
                height: 46px;
            }

            .profile-icon svg {
                width: 22px;
                height: 22px;
            }

            .vt-title {
                font-size: 11.5px;
            }

            .vt-sub {
                font-size: 10px;
            }

            .video-warning {
                font-size: 10px;
            }

            .watched-row label {
                font-size: 11px;
            }

            .start-button {
                font-size: 13px;
                padding: 12px 16px;
            }

            .form-label {
                font-size: 11px;
            }

            .form-input {
                font-size: 12px;
                padding: 11px 14px;
            }

            .btn-hint {
                font-size: 10px;
            }

            .alert {
                font-size: 11px;
            }
        }
    </style>

    <div class="exam-wrapper">
        <div class="exam-card">
            <div class="top-row">
                <a href="{{ route('camaba.exam.index') }}" class="back-link">
                    ← Kembali ke Daftar Ujian
                </a>

                <div class="test-badge">
                    @if ($isPsikotes)
                        🧠 {{ $examLabel }}
                    @else
                        📚 {{ $examLabel }}
                    @endif
                </div>
            </div>

            {{-- Alerts — sama persis dengan blade lama --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    <strong>⚠️ Error:</strong> {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <strong>✓ Berhasil:</strong> {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info">
                    <strong>ℹ️ Info:</strong> {{ session('info') }}
                </div>
            @endif

            {{-- Profile Icon --}}
            <div class="profile-icon">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}"
                    alt="Avatar" class="profile-icon-img">
            </div>

            {{-- ══════════════════════════════════════
             VIDEO TUTORIAL
             Hanya muncul jika $isPsikotes = true
             (dikirim dari showExam() di controller)
        ══════════════════════════════════════ --}}
            @if ($isPsikotes)
                <div class="video-section">
                    <div class="video-header">
                        <div class="video-header-icon">▶️</div>
                        <div class="video-header-text">
                            <p class="vt-title">Video Tutorial — {{ $examLabel }}</p>
                            <p class="vt-sub">Tonton terlebih dahulu sebelum memulai tes</p>
                        </div>
                    </div>

                    <div class="video-warning">
                        ⚠️&nbsp; Wajib ditonton. Centang konfirmasi di bawah setelah selesai menonton.
                    </div>

                    {{--
                Video embed.
                $tutorialVideoUrl dikirim dari showExam() di controller.
                Jika belum ada video di DB → tampil placeholder.
                Format YouTube embed: https://www.youtube.com/embed/VIDEO_ID
            --}}
                    <div class="video-embed">
                        @if (!empty($tutorialVideoUrl))
                            <iframe src="{{ $tutorialVideoUrl }}" title="Tutorial {{ $examLabel }}"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                            </iframe>
                        @else
                            <div class="video-placeholder">
                                <div class="play-circle">▶</div>
                                <span>Video tutorial belum tersedia</span>
                            </div>
                        @endif
                    </div>

                    <div class="watched-row" onclick="toggleWatch()">
                        <input type="checkbox" id="watchedBox" onchange="toggleWatch()">
                        <label for="watchedBox">Saya sudah menonton video tutorial ini</label>
                    </div>
                </div>
            @endif

            {{-- ══════════════════════════════════════
             FORM MULAI UJIAN
             Variable & route SAMA PERSIS dengan blade lama
        ══════════════════════════════════════ --}}
            <form id="startExamForm" action="{{ route('camaba.exam.begin') }}" method="POST">
                @csrf
                <input type="hidden" name="exam_schedule_id" value="{{ optional($schedule)->id }}">
                <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                <input type="hidden" name="exam_date" value="{{ date('Y-m-d') }}">
                <input type="hidden" name="group_id" value="{{ $groupId }}">

                {{-- Untuk psikotes: disabled sampai checkbox dicentang --}}
                <button type="submit" class="start-button" id="startBtn" {{ $isPsikotes ? 'disabled' : '' }}>
                    Mulai Ujian
                </button>
            </form>

            {{-- Hint hanya tampil untuk psikotes --}}
            @if ($isPsikotes)
                <p class="btn-hint show" id="btnHint">
                    * Tonton video tutorial dan centang konfirmasi terlebih dahulu.
                </p>
            @endif

            {{-- Info fields readonly — sama persis dengan blade lama --}}
            <div style="margin-top: 10px;">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" value="{{ Auth::user()->name }}" class="form-input" readonly />
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Ujian</label>
                    <input type="text" value="{{ date('d/m/Y') }}" class="form-input" readonly />
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Gelombang</label>
                    <input type="text" value="{{ optional($schedule)->wave_name ?? 'Tidak diketahui' }}"
                        class="form-input" readonly />
                </div>
            </div>

        </div>
    </div>

    <script>
        // Aktifkan tombol setelah checkbox dicentang (hanya untuk psikotes)
        function toggleWatch() {
            const box = document.getElementById('watchedBox');
            const btn = document.getElementById('startBtn');
            const hint = document.getElementById('btnHint');
            if (!box || !btn) return;

            if (box.checked) {
                btn.disabled = false;
                if (hint) hint.classList.remove('show');
            } else {
                btn.disabled = true;
                if (hint) hint.classList.add('show');
            }
        }

        // Prevent double submit — sama persis dengan blade lama + guard psikotes
        document.getElementById('startExamForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('startBtn');
            const box = document.getElementById('watchedBox');

            if (btn.disabled) {
                e.preventDefault();
                return false;
            }

            // Guard tambahan: psikotes wajib centang dulu
            if (box && !box.checked) {
                e.preventDefault();
                alert('⚠️ Harap tonton video tutorial dan centang konfirmasi terlebih dahulu.');
                return false;
            }

            // Konfirmasi — sama persis dengan blade lama
            if (!confirm(
                    '⚠️ Apakah Anda yakin ingin memulai ujian?\n\n• Timer akan mulai berjalan\n• Anda tidak dapat membatalkan\n• Pastikan koneksi internet stabil'
                    )) {
                e.preventDefault();
                return false;
            }

            btn.disabled = true;
            btn.textContent = '⏳ Memulai...';
        });

        // Prevent back button resubmission — sama persis dengan blade lama
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
@endsection
