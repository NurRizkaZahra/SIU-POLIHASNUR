@extends('layouts.app')

@section('title', 'Ujian')
@section('page-title', 'UJIAN')

@section('content')
<style>
    .exam-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
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

    .profile-icon {
        width: 110px;
        height: 110px;
        background: #1e3a8a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        box-shadow: 0 5px 18px rgba(30, 58, 138, 0.35);
    }

    .profile-icon svg {
        width: 58px;
        height: 58px;
        color: white;
    }

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
    }

    .form-input {
        width: 100%;
        padding: 13px 20px;
        border: 2px solid #1e3a8a;
        border-radius: 50px;
        font-size: 14px;
        color: #1e3a8a;
        background: #fff;
        text-align: left;
        font-weight: 500;
        transition: all 0.3s;
    }

    .form-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .form-input[readonly] {
        background: #f8fafc;
        cursor: not-allowed;
    }

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

    @media (max-width: 640px) {
        .exam-card {
            padding: 30px 25px;
        }

        .profile-icon {
            width: 95px;
            height: 95px;
        }

        .profile-icon svg {
            width: 48px;
            height: 48px;
        }

        .start-button {
            padding: 13px 25px;
        }

        .form-input {
            font-size: 13px;
            padding: 12px 16px;
        }
    }
</style>

<div class="exam-wrapper">
    <div class="exam-card">
        <!-- Alerts -->
        @if(session('error'))
            <div class="alert alert-danger">
                <strong>⚠️ Error:</strong> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <strong>✓ Berhasil:</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                <strong>ℹ️ Info:</strong> {{ session('info') }}
            </div>
        @endif

        <!-- Profile Icon -->
        <div class="profile-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>

        <!-- Start Button Form -->
        <form id="startExamForm" action="{{ route('exam.start') }}" method="POST">
            @csrf
            <input type="hidden" name="exam_schedule_id" value="{{ $schedules->first()->id }}">
            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
            <input type="hidden" name="exam_date" value="{{ date('Y-m-d') }}">
            
            <button type="submit" class="start-button" id="startBtn">
                Mulai Ujian
            </button>
        </form>

       
        <!-- Info Form -->
        <div style="margin-top: 30px;">
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
                <input type="text" value="{{ $schedules->first()->wave_name ?? 'Tidak diketahui' }}" class="form-input" readonly />
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('startExamForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('startBtn');
    
    // Jika sudah disabled, jangan submit
    if (btn.disabled) {
        e.preventDefault();
        return false;
    }
    
    // Konfirmasi
    if (!confirm('⚠️ Apakah Anda yakin ingin memulai ujian?\n\n• Timer akan mulai berjalan\n• Anda tidak dapat membatalkan\n• Pastikan koneksi internet stabil')) {
        e.preventDefault();
        return false;
    }
    
    // Disable button untuk prevent double submit
    btn.disabled = true;
    btn.textContent = '⏳ Memulai...';
});

// Prevent back button resubmission
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>
@endsection