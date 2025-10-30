@extends('layouts.app-admin')

@section('title', 'SIU-POLIHASNUR - Jadwal Ujian')
@section('page-title', 'JADWAL UJIAN')

@push('styles')
<style>
    .exam-schedule-container {
        padding: 2rem;
    }

    .schedule-header {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .schedule-header h2 {
        color: #0d47a1;
        margin-bottom: 1rem;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .schedule-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-left: 4px solid #0d47a1;
    }

    .schedule-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f5f5f5;
    }

    .schedule-title h3 {
        color: #0d47a1;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }

    .schedule-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-edit {
        background: #4caf50;
        color: white;
    }

    .btn-edit:hover {
        background: #45a049;
    }

    .btn-delete {
        background: #f44336;
        color: white;
    }

    .btn-delete:hover {
        background: #da190b;
    }

    .btn-add {
        background: #0d47a1;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-add:hover {
        background: #0b3d91;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 71, 161, 0.3);
    }

    .date-range-form {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .date-input-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .date-input-group label {
        font-weight: 500;
        color: #333;
    }

    .date-input {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .btn-save {
        background: #cddc39;
        color: #333;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-save:hover {
        background: #c0ca33;
    }

    .no-schedule {
        text-align: center;
        padding: 3rem;
        color: #999;
        background: white;
        border-radius: 12px;
    }

    .no-schedule i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #ddd;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #e8f5e9;
        border-left: 4px solid #4caf50;
        color: #2e7d32;
    }

    .alert-error {
        background: #ffebee;
        border-left: 4px solid #f44336;
        color: #c62828;
    }
</style>
@endpush

@section('content')
<div class="exam-schedule-container">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <div class="schedule-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Kelola Jadwal Ujian</h2>
           <a href="{{ route('admin.jadwal-ujian.create') }}" class="btn btn-primary">Tambah Jadwal</a>
                <i class="fas fa-plus"></i> Tambah Gelombang
            </a>
        </div>
    </div>

    @forelse($jadwalUjian as $jadwal)
    <div class="schedule-card">
        <div class="schedule-title">
            <h3>{{ $jadwal->nama_gelombang }} ({{ $jadwal->tanggal_mulai->format('d M Y') }} - {{ $jadwal->tanggal_selesai->format('d M Y') }})</h3>
            <div class="schedule-actions">
                <a href="{{ route('admin.jadwal-ujian.edit', $jadwal->id) }}" class="btn-action btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.jadwal-ujian.destroy', $jadwal->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gelombang ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        
        <form action="{{ route('admin.jadwal-ujian.update', $jadwal->id) }}" method="POST" class="date-range-form">
            @csrf
            @method('PUT')
            <div class="date-input-group">
                <label>Tanggal Ujian:</label>
                <input type="date" class="date-input" name="tanggal_mulai" value="{{ $jadwal->tanggal_mulai->format('Y-m-d') }}" required>
            </div>
            <span style="color: #999;">s/d</span>
            <div class="date-input-group">
                <input type="date" class="date-input" name="tanggal_selesai" value="{{ $jadwal->tanggal_selesai->format('Y-m-d') }}" required>
            </div>
            <input type="hidden" name="nama_gelombang" value="{{ $jadwal->nama_gelombang }}">
            <input type="hidden" name="kuota_peserta" value="{{ $jadwal->kuota_peserta }}">
            <input type="hidden" name="status" value="{{ $jadwal->status }}">
            <button type="submit" class="btn-save">Simpan</button>
        </form>
    </div>
    @empty
    <div class="no-schedule">
        <i class="fas fa-calendar-times"></i>
        <p>Belum ada jadwal ujian. Klik "Tambah Gelombang" untuk menambahkan jadwal baru.</p>
    </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
// Auto hide alert after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.animation = 'slideUp 0.3s ease-out';
        setTimeout(() => alert.remove(), 300);
    });
}, 5000);
</script>
@endpush