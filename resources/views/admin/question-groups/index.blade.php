@extends('layouts.app-admin')

@section('title', 'Kelompok Soal')
@section('page-title', 'KELOMPOK SOAL')

@section('content')
<style>
    .groups-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .header-section {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .btn-add-new {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fbbf24;
        color: #1e293b;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-add-new:hover {
        background: #f59e0b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        color: #1e293b;
    }
    
    .btn-icon {
        width: 16px;
        height: 16px;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border-left: 5px solid #10b981;
        color: #065f46;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        animation: slideDown 0.3s ease-out;
    }
    
    .alert-error {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border-left: 5px solid #ef4444;
        color: #991b1b;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 2px solid #e5e7eb;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        border-color: #2b6cb0;
    }
    
    .stat-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .stat-icon.blue {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    }
    
    .stat-icon.green {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    }
    
    .stat-icon.purple {
        background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%);
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1;
    }
    
    .stat-label {
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
        margin-top: 4px;
    }
    
    .groups-grid {
        display: grid;
        gap: 20px;
    }
    
    .group-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 15px;
        padding: 20px;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .group-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
    }
    
    .group-card:hover {
        border-color: #2b6cb0;
        box-shadow: 0 8px 20px rgba(43, 108, 176, 0.1);
        transform: translateY(-2px);
    }
    
    .group-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 15px;
    }
    
    .group-info {
        flex: 1;
        display: flex;
        align-items: start;
        gap: 15px;
    }
    
    .group-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        color: white;
        border-radius: 10px;
        font-weight: 700;
        font-size: 18px;
        flex-shrink: 0;
    }
    
    .group-content {
        flex: 1;
    }
    
    .group-name {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    
    .group-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .meta-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-psi {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .badge-pu {
        background: #d1fae5;
        color: #065f46;
    }
    
    .badge-questions {
        background: #f3f4f6;
        color: #374151;
    }
    
    .badge-video {
        background: #ede9fe;
        color: #7c3aed;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .badge-video:hover {
        transform: scale(1.05);
    }
    
    .group-actions {
        display: flex;
        gap: 8px;
    }
    
    .btn-action {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-edit {
        background: #10b981;
        color: white;
    }
    
    .btn-edit:hover {
        background: #059669;
        transform: scale(1.05);
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        transform: scale(1.05);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 15px;
        border: 2px dashed #cbd5e1;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        color: #cbd5e1;
    }
    
    .empty-title {
        font-size: 20px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 10px;
    }
    
    .empty-text {
        color: #94a3b8;
        font-size: 14px;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
    
    @media (max-width: 768px) {
        .groups-container {
            padding: 15px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .group-header {
            flex-direction: column;
        }
        
        .group-info {
            flex-direction: column;
        }
        
        .group-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<div class="groups-container">
    <!-- Header Section -->
    <div class="header-section">
        <a href="{{ route('admin.question-groups.create') }}" class="btn-add-new">
            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kelompok
        </a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert-success">
        <svg style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert-error">
        <svg style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Statistics -->
    @if(!$groups->isEmpty())
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">📁</div>
            </div>
            <div class="stat-value">{{ $groups->total() }}</div>
            <div class="stat-label">Total Kelompok</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">📝</div>
            </div>
            <div class="stat-value">{{ $groups->sum(fn($g) => $g->questions()->count()) }}</div>
            <div class="stat-label">Total Soal</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon purple">🎥</div>
            </div>
            <div class="stat-value">{{ $groups->whereNotNull('video_tutorial')->count() }}</div>
            <div class="stat-label">Dengan Video</div>
        </div>
    </div>
    @endif

    <!-- Groups Grid -->
    <div class="groups-grid">
        @forelse($groups as $index => $group)
        <div class="group-card">
            <div class="group-header">
                <div class="group-info">
                    <div class="group-number">{{ $groups->firstItem() + $index }}</div>
                    <div class="group-content">
                        <h3 class="group-name">{{ $group->name }}</h3>
                        
                        <div class="group-meta">
                            <span class="meta-badge {{ $group->type == 'PSI' ? 'badge-psi' : 'badge-pu' }}">
                                <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                {{ $group->type }}
                            </span>
                            
                            <span class="meta-badge badge-questions">
                                <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                                {{ $group->questions()->count() }} Soal
                            </span>
                            
                            @if($group->video_tutorial)
                            <a href="{{ $group->video_tutorial }}" target="_blank" class="meta-badge badge-video">
                                <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 6v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                </svg>
                                Video Tutorial
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="group-actions">
                    <a href="{{ route('admin.question-groups.edit', $group->id) }}" class="btn-action btn-edit" title="Edit Kelompok">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    
                    <form action="{{ route('admin.question-groups.destroy', $group->id) }}" 
                          method="POST" 
                          style="display: inline;"
                          onsubmit="return confirm('Yakin ingin menghapus kelompok \"{{ $group->name }}\"?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" title="Hapus Kelompok">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            <h2 class="empty-title">Belum Ada Kelompok Soal</h2>
            <p class="empty-text">Mulai kelompokkan soal-soal kamu berdasarkan tipe atau kategori<br>untuk memudahkan pengelolaan bank soal.</p>
            <a href="{{ route('admin.question-groups.create') }}" class="btn-add-new">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Kelompok Pertama
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($groups->hasPages())
    <div class="pagination-wrapper">
        {{ $groups->links() }}
    </div>
    @endif
</div>

<script>
// Auto hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert-success, .alert-error');
    alerts.forEach(alert => {
        alert.style.transition = 'all 0.3s ease-out';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        setTimeout(() => alert.remove(), 300);
    });
}, 5000);
</script>

@endsection