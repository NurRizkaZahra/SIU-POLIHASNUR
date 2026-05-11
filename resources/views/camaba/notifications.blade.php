@extends('layouts.app')

@section('title', 'Notifikasi')
@section('page-title', 'NOTIFIKASI')

@section('content')
<style>
    .notif-container {
        padding: 20px;
        max-width: 900px;
        margin: 0 auto;
    }
    
    .notif-header {
        background: linear-gradient(135deg, #1e5a9e 50%, #3b82f6 100%); 
        padding: 20px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .notif-header h2 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 5px 0;
    }
    
    .notif-header p {
        margin: 0;
        font-size: 13px;
        opacity: 0.9;
    }
    
    .badge-unread {
        background: #ef4444;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 14px;
    }
    
    .notif-list {
        display: grid;
        gap: 15px;
    }
    
    .notif-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .notif-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
    }
    
    .notif-card.unread {
        background: #fffbeb;
        border-color: #fbbf24;
    }
    
    .notif-card.unread::before {
        background: #fbbf24;
    }
    
    .notif-card.approved::before {
        background: #10b981;
    }
    
    .notif-card.rejected::before {
        background: #ef4444;
    }
    
    .notif-card.pending::before {
        background: #f59e0b;
    }
    
    
    .notif-top {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 12px;
    }
    
    .notif-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    
    .badge-new {
        background: #ef4444;
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
    }
    
    .notif-message {
        color: #475569;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
    }
    
    .notif-details {
        background: #f8fafc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .detail-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .detail-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }
    
    .detail-value {
        font-size: 14px;
        color: #1e293b;
        font-weight: 600;
    }
    
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }
    
    .badge-status.approved {
        background: #d1fae5;
        color: #065f46;
    }
    
    .badge-status.rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .badge-status.pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .notif-time {
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 15px;
    }
    
    .notif-actions {
        display: flex;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #e5e7eb;
    }
    
    .btn-action {
        flex: 1;
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-start {
        background: #fbbf24;
        color: #1e293b;
    }
    
    .btn-start:hover {
        background: #f59e0b;
        transform: translateY(-2px);
    }
    
    .btn-contact {
        background: #1e5a96;
        color: white;
    }
    
    .btn-contact:hover {
        background: #0d3d6b;
        transform: translateY(-2px);
    }
    
    .btn-waiting {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 12px;
        border: 2px dashed #cbd5e1;
    }
    
    .empty-icon {
        font-size: 80px;
        margin-bottom: 20px;
    }
    
    .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 10px;
    }
    
    .empty-text {
        color: #94a3b8;
        font-size: 14px;
    }
    
    @media (max-width: 768px) {
        .notif-container {
            padding: 15px;
        }
        
        .notif-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
        
        .notif-actions {
            flex-direction: column;
        }
        
        .detail-row {
            grid-template-columns: 1fr;
        }
    }
    /* =========================
   TABLET RESPONSIVE
========================= */
@media (max-width: 768px) {

    .notif-container {
        padding: 15px;
    }

    .notif-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
        padding: 18px;
    }

    .notif-header h2 {
        font-size: 18px;
        line-height: 1.4;
    }

    .notif-header p {
        font-size: 12px;
    }

    .badge-unread {
        align-self: flex-start;
        font-size: 13px;
        padding: 7px 14px;
    }

    .notif-card {
        padding: 18px;
    }

    .notif-top {
        gap: 10px;
    }

    .notif-title {
        font-size: 16px;
        line-height: 1.4;
    }

    .notif-message {
        font-size: 13px;
        line-height: 1.7;
    }

    .notif-details {
        padding: 14px;
    }

    .detail-row {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .detail-label {
        font-size: 11px;
    }

    .detail-value {
        font-size: 13px;
    }

    .notif-actions {
        flex-direction: column;
    }

    .notif-actions form {
        width: 100%;
    }

    .btn-action {
        width: 100%;
        padding: 11px 16px;
        font-size: 13px;
    }

    .notif-time {
        font-size: 11px;
    }

    .empty-state {
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 60px;
    }

    .empty-title {
        font-size: 18px;
    }

    .empty-text {
        font-size: 13px;
    }
}

/* =========================
   SMALL MOBILE
========================= */
@media (max-width: 480px) {

    .notif-container {
        padding: 10px;
    }

    .notif-header {
        padding: 16px;
        border-radius: 10px;
    }

    .notif-header h2 {
        font-size: 16px;
    }

    .notif-header p {
        font-size: 11px;
    }

    .badge-unread {
        font-size: 12px;
        padding: 6px 12px;
    }

    .notif-card {
        padding: 15px;
        border-radius: 10px;
    }

    .notif-title {
        font-size: 15px;
    }

    .badge-new {
        font-size: 10px;
        padding: 3px 8px;
    }

    .notif-message {
        font-size: 12px;
    }

    .notif-details {
        padding: 12px;
    }

    .detail-item {
        gap: 3px;
    }

    .detail-label {
        font-size: 10px;
    }

    .detail-value {
        font-size: 12px;
        line-height: 1.5;
    }

    .badge-status {
        width: fit-content;
        font-size: 11px;
        padding: 5px 10px;
    }

    .btn-action {
        min-height: 44px;
        font-size: 12px;
        border-radius: 7px;
    }

    .notif-time {
        font-size: 10px;
    }

    .empty-state {
        padding: 50px 15px;
    }

    .empty-icon {
        font-size: 50px;
    }

    .empty-title {
        font-size: 16px;
    }

    .empty-text {
        font-size: 12px;
        line-height: 1.5;
    }
}

/* =========================
   EXTRA FIX
========================= */

/* Hindari overflow */
body {
    overflow-x: hidden;
}

/* Biar text panjang aman */
.notif-title,
.notif-message,
.detail-value {
    word-break: break-word;
}

/* Form button full width */
.notif-actions form {
    flex: 1;
}

/* Tombol tidak mengecil */
.btn-action {
    white-space: nowrap;
}
</style>

<div class="notif-container">
    <!-- Header -->
    <div class="notif-header">
        <div>
            <h2>📬 Notifikasi Pengajuan Ujian</h2>
            <p>Pantau status terbaru dari pengajuan ujian Anda</p>
        </div>
        @if($unreadCount > 0)
        <div class="badge-unread">{{ $unreadCount }} Baru</div>
        @endif
    </div>

    <!-- Notification List -->
    <div class="notif-list">
        @forelse($notifications as $notif)
        <div class="notif-card {{ $notif->is_read ? '' : 'unread' }} {{ $notif->exam->status ?? 'pending' }}">
            <div class="notif-top">
                <h3 class="notif-title">{{ $notif->title }}</h3>
                @if(!$notif->is_read)
                <span class="badge-new">BARU</span>
                @endif
            </div>
            
            <p class="notif-message">{{ $notif->message }}</p>
            
            <div class="notif-details">
                <div class="detail-row">
                    <div class="detail-item">
                        <span class="detail-label">Gelombang</span>
                        <span class="detail-value">{{ $notif->examSchedule->wave_name ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status</span>
                        <span class="badge-status {{ $notif->exam->status ?? 'pending' }}">
                            @switch($notif->exam->status ?? 'pending')
                                @case('approved')
                                    ✓ Disetujui
                                    @break
                                @case('rejected')
                                    ✕ Ditolak
                                    @break
                                @default
                                    ⏱ Menunggu
                            @endswitch
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tanggal Ujian</span>
                        <span class="detail-value">
                          {{ $notif->examSchedule?->start_date
    ? \Carbon\Carbon::parse($notif->examSchedule->start_date)->format('d M Y')
    : '-' }}
                        </span>
                    </div>
                </div>
            </div>
            
            @if(($notif->exam->status ?? 'pending') == 'rejected' && $notif->rejection_reason)
            <div style="background: #fee2e2; border: 1px solid #ef4444; border-radius: 8px; padding: 12px; margin-bottom: 15px;">
                <p style="margin: 0; font-size: 13px; color: #991b1b;">
                    <strong>Alasan Penolakan:</strong> {{ $notif->rejection_reason }}
                </p>
            </div>
            @endif
            
            <div class="notif-time">
                🕒 {{ $notif->created_at->diffForHumans() }}
            </div>
            
            <div class="notif-actions">
                @switch($notif->exam->status ?? 'pending')
                    @case('approved')
    @if($notif->examSchedule)
        <form action="{{ route('camaba.exam.begin', $notif->examSchedule->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-action btn-start">
                ▶️ Mulai Ujian
            </button>
        </form>
    @else
        <button class="btn-action btn-waiting" disabled>
            Jadwal tidak tersedia
        </button>
    @endif
@break
                    
                    @case('rejected')
                        <button class="btn-action btn-contact" onclick="contactAdmin()">
                            📞 Hubungi Admin
                        </button>
                        @break
                    
                    @default
                        <button class="btn-action btn-waiting" disabled>
                            ⏳ Menunggu Persetujuan
                        </button>
                @endswitch
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">🔔</div>
            <div class="empty-title">Belum Ada Notifikasi</div>
            <div class="empty-text">Notifikasi status pengajuan ujian akan muncul di sini</div>
        </div>
        @endforelse
    </div>
</div>

@endsection