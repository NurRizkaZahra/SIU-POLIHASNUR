@extends('layouts.app-admin')

@section('title', 'Notifikasi')

@section('content')
<div class="notification-container">
    <div class="notification-header">
        <h1>NOTIFIKASI</h1>
        @if($pendingExams->count() > 0)
            <span class="badge-new">{{ $pendingExams->count() }} Baru</span>
        @endif
    </div>

    <div class="notification-content">
        <div class="notification-title">
            <h2>Notifikasi</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($pendingExams->count() > 0)
            @foreach($pendingExams as $exam)
            <div class="notification-card">
                <div class="card-header">
                    <div class="card-icon">📋</div>
                    <div class="card-title">
                        <strong>Pengajuan Jadwal Ujian Baru</strong>
                        <span class="badge-baru">Baru</span>
                    </div>
                </div>

                <div class="card-body">
                    <p class="time-info">{{ $exam->created_at->diffForHumans() }}</p>
                    
                    <div class="info-row">
                        <strong>{{ $exam->user->name ?? 'Unknown User' }}</strong>
                    </div>
                    
                    @if($exam->user->email)
                    <div class="info-row">
                        Email: {{ $exam->user->email }}
                    </div>
                    @endif

                    @if($exam->examSchedule)
                    <div class="info-row">
                        <strong>Gelombang:</strong> {{ $exam->examSchedule->wave_name }}
                    </div>
                    <div class="info-row">
                        <strong>Tanggal:</strong> {{ $exam->examSchedule->start_date->format('d M Y') }} - {{ $exam->examSchedule->end_date->format('d M Y') }}
                    </div>
                    @endif

                    @if($exam->start_time && $exam->end_time)
                    <div class="info-row">
                        <strong>Waktu:</strong> {{ $exam->start_time->format('H:i') }} - {{ $exam->end_time->format('H:i') }} WIB
                    </div>
                    @endif

                    @if($exam->examSchedule)
                    <div class="info-row">
                        <strong>Kuota Tersisa:</strong> {{ $exam->examSchedule->getRemainingQuota() }} / {{ $exam->examSchedule->participant_quota }}
                    </div>
                    @endif
                </div>

                <div class="card-actions">
                    <form action="{{ route('admin.exam.approve', $exam->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-terima" onclick="return confirm('Terima pengajuan jadwal ujian ini?')">
                            TERIMA
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.exam.reject', $exam->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-tolak" onclick="return confirm('Tolak pengajuan jadwal ujian ini?')">
                            TOLAK
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3>Tidak Ada Notifikasi</h3>
                <p>Semua pengajuan jadwal ujian sudah diproses.</p>
            </div>
        @endif
    </div>
</div>

<style>
.notification-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background: #f5f5f5;
    min-height: 100vh;
}

.notification-header {
    background: linear-gradient(135deg, #1e5a9e 50%, #3b82f6 100%); 
    color: white;
    padding: 20px;
    border-radius: 10px 10px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.notification-header h1 {
    font-size: 24px;
    font-weight: bold;
    margin: 0;
}

.badge-new {
    background: #ef4444;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
}

.notification-content {
    background: white;
    border-radius: 10px;
    padding: 20px;
}

.notification-title {
    margin-bottom: 20px;
}

.notification-title h2 {
    font-size: 20px;
    font-weight: bold;
    color: #333;
}

.notification-card {
    background: white;
    border: 3px solid #fbbf24;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f3f4f6;
}

.card-icon {
    font-size: 24px;
}

.card-title {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}

.card-title strong {
    color: #1f2937;
    font-size: 16px;
}

.badge-baru {
    background: #ef4444;
    color: white;
    padding: 3px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

.card-body {
    margin-bottom: 15px;
    line-height: 1.8;
}

.time-info {
    color: #6b7280;
    font-size: 13px;
    margin-bottom: 10px;
}

.info-row {
    color: #374151;
    font-size: 14px;
    margin-bottom: 5px;
}

.card-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-start;
}

.btn {
    padding: 10px 30px;
    border: none;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s;
}

.btn-terima {
    background: #fbbf24;
    color: #1f2937;
}

.btn-terima:hover {
    background: #f59e0b;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(251, 191, 36, 0.3);
}

.btn-tolak {
    background: #1e40af;
    color: white;
}

.btn-tolak:hover {
    background: #1e3a8a;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(30, 64, 175, 0.3);
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    background: #d1fae5;
    border: 1px solid #10b981;
    color: #065f46;
}

.alert-error {
    background: #fee2e2;
    border: 1px solid #ef4444;
    color: #991b1b;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    color: #d1d5db;
    margin: 0 auto 20px;
}

.empty-state h3 {
    font-size: 18px;
    color: #374151;
    margin-bottom: 10px;
}

.empty-state p {
    color: #6b7280;
    font-size: 14px;
}
</style>
@endsection