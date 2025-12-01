@extends('layouts.app')

@section('page-title', 'Ujian Selesai')

@section('content')
<style>
    .success-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        padding: 1rem;
    }

    .success-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 1.5rem 1.8rem;
        max-width: 400px;
        width: 100%;
        text-align: center;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
        animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .success-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 1rem;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: scaleIn 0.6s ease 0.2s both;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-icon svg {
        width: 35px;
        height: 35px;
        stroke: #667eea;
        stroke-width: 4;
        fill: none;
    }

    .success-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        line-height: 1.3;
    }

    .success-message {
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.7;
        margin-bottom: 2rem;
    }

    .exam-info-box {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.35rem 0;
        font-size: 0.85rem;
    }

    .info-label {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
    }

    .info-value {
        color: white;
        font-weight: 700;
    }

    .submit-time {
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.7rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        line-height: 1.5;
    }

    .note-text {
        background: rgba(255, 243, 205, 0.95);
        border: 1px solid #ffc107;
        border-radius: 8px;
        padding: 1rem;
        color: #856404;
        font-size: 0.9rem;
        margin-top: 1.5rem;
        line-height: 1.6;
    }

    .btn-back {
        background: white;
        color: #667eea;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-top: 0.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-back:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        color: #667eea;
    }

    @media (max-width: 768px) {
        .success-card {
            padding: 2rem 1.5rem;
        }

        .success-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="success-wrapper">
    <div class="success-card">
        <!-- Success Icon -->
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <!-- Title -->
        <h1 class="success-title">
            Selamat! Anda telah menyelesaikan Ujian/Seleksi
        </h1>
        
        <!-- Exam Info -->
        <div class="exam-info-box">
            <div class="info-row">
                <span class="info-label">📋 Jumlah Pertanyaan:</span>
                <span class="info-value">{{ $totalQuestions }} soal</span>
            </div>
            <div class="info-row">
                <span class="info-label">✅ Soal Terjawab:</span>
                <span class="info-value">{{ $answeredCount }} soal</span>
            </div>
            <div class="info-row">
                <span class="info-label">⏱️ Durasi:</span>
                <span class="info-value">{{ $exam->examSchedule->duration }} menit</span>
            </div>
        </div>

        <!-- Submit Time -->
        <div class="submit-time">
            Submit<br>
            @if($exam->finished_at)
                {{ $exam->finished_at->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            @else
                {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            @endif
        </div>

        <!-- Back Button -->
        <a href="{{ route('dashboard.camaba') }}" class="btn-back">
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection