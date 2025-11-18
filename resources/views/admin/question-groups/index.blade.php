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
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .header-title {
        margin: 0;
        color: #ffffff;
        font-size: 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .header-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .btn-add-new {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: #1e293b;
        padding: 14px 28px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.4);
    }
    
    .btn-add-new:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(251, 191, 36, 0.5);
        color: #1e293b;
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
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
    }
    
    .stat-label {
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
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
        padding: 25px;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .group-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        transition: width 0.3s;
    }
    
    .group-card:hover {
        border-color: #2b6cb0;
        box-shadow: 0 10px 30px rgba(43, 108, 176, 0.15);
        transform: translateY(-3px);
    }
    
    .group-card:hover::before {
        width: 10px;
    }
    
    .group-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .group-info {
        flex: 1;
    }
    
    .group-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        color: white;
        border-radius: 12px;
        font-weight: 800;
        font-size: 20px;
        margin-bottom: 15px;
    }
    
    .group-name {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
        line-height: 1.3;
    }
    
    .group-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 15px;
    }
    
    .meta-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 700;
    }
    
    .badge-psi {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        border: 2px solid #3b82f6;
    }
    
    .badge-pu {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border: 2px solid #10b981;
    }
    
    .badge-questions {
        background: #f3f4f6;
        color: #374151;
        border: 2px solid #d1d5db;
    }
    
    .badge-video {
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
        color: #6d28d9;
        border: 2px solid #8b5cf6;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .badge-video:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }
    
    .group-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-action {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        font-size: 18px;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-edit:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .btn-delete:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        border: 3px dashed #cbd5e1;
    }
    
    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 25px;
        color: #cbd5e1;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .empty-title {
        font-size: 26px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 12px;
    }
    
    .empty-text {
        color: #94a3b8;
        font-size: 16px;
        margin-bottom: 30px;
        line-height: 1.6;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 35px;
    }
    
    @media (max-width: 768px) {
        .groups-container {
            padding: 15px;
        }
        
        .header-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .header-title {
            font-size: 24px;
        }
        
        .btn-add-new {
            justify-content: center;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .group-header {
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
            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                            </svg>
                            Video Tutorial
                        </a>
                        @endif
                    </div>
                </div>
                
                <div class="group-actions">
                    <a href="{{ route('admin.question-groups.edit', $group->id) }}" class="btn-action btn-edit" title="Edit Kelompok">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    
                    <form action="{{ route('admin.question-groups.destroy', $group->id) }}" 
                          method="POST" 
                          style="display: inline;"
                          onsubmit="return confirm('Yakin ingin menghapus kelompok \"{{ $group->name }}\"?\n\nSemua soal dalam kelompok ini akan tetap ada.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" title="Hapus Kelompok">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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