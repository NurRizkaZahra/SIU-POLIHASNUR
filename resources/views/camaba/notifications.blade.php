@extends('layouts.app')

@section('title', 'Notifikasi')
@section('page-title', 'NOTIFIKASI')

@section('content')
<div class="container-fluid px-4 py-4">
    {{-- Header Section --}}
    <div class="header-section shadow-lg mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold text-white">📬 Notifikasi Pengajuan Ujian</h4>
                <p class="mb-0 text-white-50 small">Pantau status terbaru dari pengajuan ujian Anda</p>
            </div>
            @if($unreadCount > 0)
                <span class="badge-baru animate__animated animate__pulse animate__infinite">
                    {{ $unreadCount }} Baru
                </span>
            @endif
        </div>
    </div>
    
    {{-- Notification List --}}
    <div class="notification-container">
        @forelse($notifications as $notif)
            {{-- Notification Card --}}
            <div class="notifikasi-card {{ $notif->is_read ? '' : 'unread-card' }}" 
                 data-bs-toggle="modal" 
                 data-bs-target="#modal{{ $notif->id }}"
                 onclick="markAsRead({{ $notif->id }})">
                
                <div class="d-flex align-items-start gap-3 flex-grow-1">
                    {{-- Icon --}}
                    <div class="notif-icon {{ $notif->status }}">
                        @switch($notif->status)
                            @case('approved')
                                <i class="fas fa-check-circle"></i>
                                @break
                            @case('rejected')
                                <i class="fas fa-times-circle"></i>
                                @break
                            @default
                                <i class="fas fa-clock"></i>
                        @endswitch
                    </div>

                    {{-- Content --}}
                    <div class="flex-grow-1">
                        {{-- Title & Badge --}}
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0 fw-bold notif-title">{{ $notif->title }}</h6>
                            @if(!$notif->is_read)
                                <span class="badge bg-primary ms-2 new-badge">BARU</span>
                            @endif
                        </div>

                        {{-- Status Badge --}}
                        <span class="status-badge {{ $notif->status }} mb-2">
                            @switch($notif->status)
                                @case('approved')
                                    <i class="fas fa-check me-1"></i>Disetujui
                                    @break
                                @case('rejected')
                                    <i class="fas fa-times me-1"></i>Ditolak
                                    @break
                                @default
                                    <i class="fas fa-hourglass-half me-1"></i>Menunggu
                            @endswitch
                        </span>
                        
                        {{-- Info --}}
                        <div class="notif-info mt-2">
                            <div class="info-item">
                                <i class="fas fa-layer-group me-1 text-muted"></i>
                                <span class="small fw-semibold">{{ $notif->gelombang }}</span>
                            </div>
                            <div class="info-item">
                                <i class="far fa-calendar me-1 text-primary"></i>
                                <span class="small">
                                    {{ \Carbon\Carbon::parse($notif->tanggal_mulai)->format('d M') }} - 
                                    {{ \Carbon\Carbon::parse($notif->tanggal_selesai)->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        {{-- Time --}}
                        <small class="text-muted d-block mt-2 notif-time">
                            <i class="far fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
                
                {{-- Actions --}}
                <div class="notif-actions mt-3">
                    @switch($notif->status)
                        @case('approved')
                            <button class="btn-action success-yellow" 
                                    onclick="event.stopPropagation(); startExam({{ $notif->exam_id }})">
                                <i class="fas fa-play-circle me-2"></i>Mulai Ujian
                            </button>
                            @break
                        
                        @case('rejected')
                            <button class="btn-action primary-figma" 
                                    onclick="event.stopPropagation(); contactAdmin()">
                                <i class="fas fa-headset me-2"></i>Hubungi Admin
                            </button>
                            @break
                        
                        @default
                            <button class="btn-action disabled" disabled>
                                <i class="fas fa-hourglass-half me-2"></i>Menunggu Persetujuan
                            </button>
                    @endswitch
                </div>
            </div>

            {{-- Modal --}}
            <div class="modal fade" id="modal{{ $notif->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg modal-modern">
                        
                        {{-- Header --}}
                        <div class="modal-header border-0 modal-header-{{ $notif->status }}">
                            <div>
                                <h5 class="modal-title fw-bold mb-1 text-white">
                                    @switch($notif->status)
                                        @case('approved')
                                            <i class="fas fa-check-circle me-2"></i>Pengajuan Disetujui
                                            @break
                                        @case('rejected')
                                            <i class="fas fa-times-circle me-2"></i>Pengajuan Ditolak
                                            @break
                                        @default
                                            <i class="fas fa-clock me-2"></i>Menunggu Persetujuan
                                    @endswitch
                                </h5>
                                <small class="text-white-75">{{ $notif->title }}</small>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        {{-- Body --}}
                        <div class="modal-body p-4">
                            {{-- Alert --}}
                            <div class="alert alert-modern-{{ $notif->status }} d-flex align-items-start p-3">
                                <div class="me-3">
                                    @switch($notif->status)
                                        @case('approved')
                                            <i class="fas fa-check-circle fa-2x"></i>
                                            @break
                                        @case('rejected')
                                            <i class="fas fa-times-circle fa-2x"></i>
                                            @break
                                        @default
                                            <i class="fas fa-hourglass-half fa-2x"></i>
                                    @endswitch
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-2">
                                        @switch($notif->status)
                                            @case('approved')
                                                🎉 Selamat! Pengajuan ujian Anda telah disetujui
                                                @break
                                            @case('rejected')
                                                ❌ Pengajuan ujian Anda ditolak
                                                @break
                                            @default
                                                ⏳ Pengajuan Anda sedang diproses
                                        @endswitch
                                    </h6>
                                    <p class="mb-0">{{ $notif->message }}</p>
                                    
                                    @if($notif->status == 'rejected' && isset($notif->rejection_reason))
                                        <hr class="my-2 border-dashed">
                                        <p class="mb-0">
                                            <strong>Alasan Penolakan:</strong> {{ $notif->rejection_reason }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Detail Box --}}
                            <div class="detail-box my-4">
                                <h6 class="fw-bold mb-3 text-primary detail-title">
                                    <i class="fas fa-info-circle me-2"></i>Detail Jadwal Ujian
                                </h6>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="info-card-detail">
                                            <label class="text-muted small mb-1">Gelombang</label>
                                            <p class="fw-semibold mb-0">{{ $notif->gelombang }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="info-card-detail">
                                            <label class="text-muted small mb-1">Status</label>
                                            <p class="mb-0">
                                                <span class="badge badge-lg status-badge-detail {{ $notif->status }}">
                                                    @switch($notif->status)
                                                        @case('approved')
                                                            Disetujui
                                                            @break
                                                        @case('rejected')
                                                            Ditolak
                                                            @break
                                                        @default
                                                            Menunggu
                                                    @endswitch
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="info-card-detail">
                                            <label class="text-muted small mb-1">Tanggal Mulai</label>
                                            <p class="fw-semibold mb-0">
                                                <i class="far fa-calendar-alt text-primary me-1"></i>
                                                {{ \Carbon\Carbon::parse($notif->tanggal_mulai)->format('d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="info-card-detail">
                                            <label class="text-muted small mb-1">Tanggal Selesai</label>
                                            <p class="fw-semibold mb-0">
                                                <i class="far fa-calendar-alt text-primary me-1"></i>
                                                {{ \Carbon\Carbon::parse($notif->tanggal_selesai)->format('d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tips untuk Rejected --}}
                            @if($notif->status == 'rejected')
                                <div class="tips-box warning-tips shadow-sm">
                                    <h6 class="fw-bold mb-2">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Apa yang harus dilakukan?
                                    </h6>
                                    <ul class="mb-0 ps-3">
                                        <li><strong>Hubungi admin</strong> untuk klarifikasi alasan penolakan lebih detail.</li>
                                        <li>Periksa kembali semua <strong>persyaratan dokumen</strong> yang diperlukan.</li>
                                        <li>Anda dapat mengajukan kembali pada gelombang berikutnya setelah memperbaiki kekurangan.</li>
                                    </ul>
                                </div>
                            @endif

                            <hr class="mt-4 mb-3">
                            <p class="text-muted small mb-0 text-end">
                                <i class="far fa-clock me-1"></i>Diterima: {{ $notif->created_at->format('d F Y, H:i') }} WIB
                            </p>
                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer border-0 p-3 modal-footer-modern">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Tutup
                            </button>
                            
                            @if($notif->status == 'approved')
                                <button type="button" class="btn btn-primary btn-sm" 
                                        onclick="startExam({{ $notif->exam_id }})">
                                    <i class="fas fa-play-circle me-1"></i>Mulai Ujian
                                </button>
                            @elseif($notif->status == 'rejected')
                                <button type="button" class="btn btn-info btn-sm" onclick="contactAdmin()">
                                    <i class="fas fa-headset me-1"></i>Hubungi Admin
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        @empty
            {{-- Empty State --}}
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-bell-slash"></i>
                </div>
                <h5 class="fw-bold mb-2">Belum Ada Notifikasi</h5>
                <p class="text-muted mb-0">
                    Notifikasi status pengajuan ujian akan muncul di sini.
                </p>
            </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
/* ===================================
   CSS VARIABLES
   =================================== */
:root {
    /* Figma Color Palette */
    --figma-blue-dark: #1f3f6c;
    --figma-blue-light: #4a6fa5;
    --figma-yellow: #f1c40f;
    --figma-red: #e74c3c;
    
    /* Base Colors */
    --bg-light: #f7f9fc;
    --text-dark: #34495e;

    /* Status Colors */
    --primary: var(--figma-blue-dark); 
    --success: var(--figma-yellow);
    --danger: var(--figma-red); 
    --warning: var(--figma-yellow);
    
    /* Light Variants */
    --primary-light: #e6e9ff; 
    --success-light: #fffce6;
    --danger-light: #ffe5e5;
    --warning-light: #fffaf0;
}

/* ===================================
   LAYOUT
   =================================== */
.container-fluid {
    background-color: var(--bg-light);
}

.header-section {
    background: var(--figma-blue-dark);
    padding: 2.5rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(31, 63, 108, 0.3); 
}

.badge-baru {
    background: var(--figma-red); 
    color: white;
    padding: 0.6rem 1.4rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.9rem;
    box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.notification-container {
    display: grid;
    gap: 1.5rem;
    grid-template-columns: 1fr; 
    max-width: 700px;
    margin: 0 auto; 
}

/* ===================================
   NOTIFICATION CARD
   =================================== */
.notifikasi-card {
    background: white;
    border: 1px solid #e8ecef;
    border-radius: 16px;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
}

.notifikasi-card:hover {
    box-shadow: 0 16px 32px rgba(31, 63, 108, 0.15); 
    transform: translateY(-4px);
    border-color: var(--figma-blue-light);
}

.notifikasi-card.unread-card {
    border-left: 5px solid var(--figma-yellow);
    background: var(--warning-light); 
    box-shadow: 0 4px 12px rgba(241, 196, 15, 0.2);
}

/* ===================================
   NOTIFICATION ICON
   =================================== */
.notif-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    flex-shrink: 0;
    color: var(--figma-blue-dark);
}

.notif-icon.approved { background: var(--figma-yellow); }
.notif-icon.rejected { background: var(--danger); }
.notif-icon.pending { background: var(--warning); }

/* ===================================
   NOTIFICATION CONTENT
   =================================== */
.notif-title {
    color: var(--text-dark);
    font-size: 1.05rem;
}

/* ===================================
   NOTIFICATION INFO
   =================================== */
.notif-info {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
}

.info-item {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    color: var(--text-dark);
}

.info-item i {
    font-size: 0.9rem;
}

.new-badge {
    background-color: var(--figma-red) !important;
    color: white;
    font-weight: 700;
    font-size: 0.75rem;
    padding: 0.25em 0.6em;
    border-radius: 0.5rem;
}

.status-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
}

.status-badge.approved {
    background: var(--success-light);
    color: var(--figma-yellow);
}

.status-badge.rejected { color: var(--danger); }
.status-badge.pending { color: var(--warning); }

/* ===================================
   ACTION BUTTONS
   =================================== */
.notif-actions {
    border-top: 1px solid #e0e0e0;
    padding-top: 1rem;
    margin-top: 1.5rem;
}

.btn-action {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-action.success-yellow {
    background-color: var(--figma-yellow);
    color: var(--figma-blue-dark);
    box-shadow: 0 4px 15px rgba(241, 196, 15, 0.4);
}

.btn-action.primary-figma {
    background-color: var(--figma-blue-dark);
    color: white;
    box-shadow: 0 4px 15px rgba(31, 63, 108, 0.4);
}

.btn-action:hover:not(.disabled) {
    transform: translateY(-2px);
    opacity: 0.9;
}

.btn-action.disabled {
    background: #f1f5f9;
    color: #94a3b8;
    cursor: not-allowed;
    box-shadow: none;
}

/* ===================================
   MODAL STYLES
   =================================== */
.modal-modern .modal-content {
    border-radius: 16px;
}

.modal-header-approved {
    background: var(--figma-yellow);
    color: var(--figma-blue-dark);
}

.modal-header-rejected { background: var(--danger); }
.modal-header-pending { background: var(--warning); }

.modal-header-approved .modal-title,
.modal-header-approved .text-white-75 {
    color: var(--figma-blue-dark) !important; 
}

.modal-header-approved .btn-close-white {
    filter: invert(30%);
}

/* ===================================
   MODAL ALERTS
   =================================== */
.alert-modern-approved {
    background-color: var(--success-light);
    color: var(--figma-blue-dark);
    border: 1px solid var(--figma-yellow);
}

.alert-modern-rejected {
    background-color: var(--danger-light);
    color: var(--danger);
    border: 1px solid var(--danger);
}

.alert-modern-pending {
    background-color: var(--warning-light);
    color: var(--warning);
    border: 1px solid var(--warning);
}

.detail-title {
    color: var(--figma-blue-dark);
}

.modal-footer-modern {
    background-color: #f7f9fc;
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 16px;
}

.modal-footer .btn-primary {
    background-color: var(--figma-yellow) !important;
    border-color: var(--figma-yellow) !important;
    color: var(--figma-blue-dark) !important;
}

.modal-footer .btn-info {
    background-color: var(--figma-blue-dark) !important;
    border-color: var(--figma-blue-dark) !important;
    color: white;
}

/* ===================================
   EMPTY STATE
   =================================== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.empty-icon {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

/* ===================================
   RESPONSIVE
   =================================== */
@media (max-width: 768px) {
    .header-section {
        padding: 1.5rem;
        border-radius: 16px;
    }

    .notif-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .notification-container {
        max-width: 100%;
        margin: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
/**
 * Mark notification as read
 * @param {number} notifId - The notification ID
 */
function markAsRead(notifId) {
    const modal = document.querySelector(`#modal${notifId}`);
    if (!modal) return;
    
    const notifCard = modal.closest('.notifikasi-card');
    
    // Only proceed if notification is unread
    if (notifCard && notifCard.classList.contains('unread-card')) {
        fetch(`/camaba/notifikasi/${notifId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal menandai sebagai dibaca');
            }
            return response.json();
        })
        .then(data => {
            console.log('Notifikasi ditandai sebagai dibaca');
            location.reload(); 
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }
}

/**
 * Start exam
 * @param {number} examId - The exam ID
 */
function startExam(examId) {
    const confirmed = confirm(
        'Apakah Anda siap memulai ujian sekarang? ' +
        'Pastikan Anda sudah memenuhi semua persyaratan.'
    );
    
    if (confirmed) {
        window.location.href = `/camaba/exam/${examId}/start`;
    }
}

/**
 * Contact admin
 */
function contactAdmin() {
    window.location.href = '/camaba/support'; 
}
</script>
@endpush
@endsection