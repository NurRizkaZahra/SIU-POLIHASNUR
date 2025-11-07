@extends('layouts.app')

@section('title', 'Ujian')
@section('page-title', 'UJIAN')

@section('content')
<style>
    /* Wrapper mengikuti layout utama, tanpa ubah background sidebar */
    .exam-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 40px 20px;
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
        margin-left: auto;
        margin-right: auto;
    }

    .start-button:hover {
        background: #152d6b;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.45);
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
            width: 100%;
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
        <!-- Profile Icon -->
        <div class="profile-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>

        <!-- Start Button -->
        <button onclick="handleStartExam()" class="start-button">
            Mulai Ujian
        </button>

        <!-- Form -->
        <form id="examForm">
            <!-- Nama Lengkap -->
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap"
                    value="{{ Auth::user()->name ?? 'Nur Rizka Zahra' }}" class="form-input" readonly />
            </div>

            <!-- Tanggal Ujian -->
            <div class="form-group">
                <label class="form-label">Tanggal Ujian</label>
                <input type="text" name="tanggal_ujian" value="{{ date('d/m/Y') }}" class="form-input"
                    readonly />
            </div>
        </form>
    </div>
</div>

<script>
function handleStartExam() {
    if (confirm('Apakah Anda yakin ingin memulai ujian?')) {
        window.location.href = "{{ route('ujian.start') }}";
    }
}
</script>
@endsection
