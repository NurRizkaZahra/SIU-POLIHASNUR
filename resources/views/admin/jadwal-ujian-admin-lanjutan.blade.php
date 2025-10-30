@extends('layouts.app-admin')

@section('title', 'SIU-POLIHASNUR - Tambah Gelombang')
@section('page-title', 'JADWAL UJIAN')

@push('styles')
<style>
    .form-container {
        padding: 2rem;
        max-width: 900px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .form-header {
        padding: 1.5rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-header h2 {
        margin: 0;
        color: #333;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .btn-back {
        background: none;
        border: none;
        color: #0d47a1;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        padding: 0.5rem 1rem;
    }

    .btn-back:hover {
        color: #0b3d91;
        text-decoration: underline;
    }

    .form-body {
        padding: 2rem;
    }

    .alert-warning {
        background: #e3f2fd;
        border-left: 4px solid #f44336;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }

    .alert-warning i {
        color: #d32f2f;
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .alert-warning p {
        margin: 0;
        color: #c62828;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
    }

    .form-group label .required {
        color: #f44336;
        margin-left: 2px;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        border-color: #0d47a1;
        box-shadow: 0 0 0 3px rgba(13, 71, 161, 0.1);
    }

    .form-input::placeholder {
        color: #999;
    }

    .form-hint {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #666;
    }

    .date-range-wrapper {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 1rem;
        align-items: start;
    }

    .date-separator {
        color: #999;
        font-weight: 500;
        padding-top: 0.75rem;
        text-align: center;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    select.form-input {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
    }

    .form-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        background: #f9f9f9;
    }

    .btn-form {
        padding: 0.75rem 2.5rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-cancel {
        background: #cddc39;
        color: #333;
    }

    .btn-cancel:hover {
        background: #c0ca33;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(205, 220, 57, 0.3);
    }

    .btn-submit {
        background: #0d47a1;
        color: white;
    }

    .btn-submit:hover {
        background: #0b3d91;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 71, 161, 0.3);
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .date-range-wrapper {
            grid-template-columns: 1fr;
        }

        .date-separator {
            padding: 0;
        }

        .form-footer {
            flex-direction: column;
        }

        .btn-form {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h2>Tambahkan Gelombang Baru</h2>
            <a href="{{ route('jadwal-ujian-admin.create') }}" class="btn-back">kembali</a>
        </div>

        <form action="{{ route('jadwal-ujian.store') }}" method="POST">
            @csrf
            <div class="form-body">
                <div class="alert-warning">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Pastikan tanggal ujian tidak bentrok dengan gelombang lain</p>
                </div>

                <div class="form-group">
                    <label for="nama_gelombang">
                        Nama Gelombang <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nama_gelombang"
                        name="nama_gelombang" 
                        class="form-input" 
                        placeholder="Contoh : Gelombang 1" 
                        value="{{ old('nama_gelombang') }}"
                        required
                    >
                    <small class="form-hint">Nama gelombang akan ditampilkan ke calon mahasiswa</small>
                    @error('nama_gelombang')
                        <small class="form-hint" style="color: #f44336;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        Tanggal Ujian <span class="required">*</span>
                    </label>
                    <div class="date-range-wrapper">
                        <div>
                            <input 
                                type="date" 
                                name="tanggal_mulai" 
                                class="form-input"
                                value="{{ old('tanggal_mulai') }}"
                                required
                            >
                        </div>
                        <span class="date-separator">s/d</span>
                        <div>
                            <input 
                                type="date" 
                                name="tanggal_selesai" 
                                class="form-input"
                                value="{{ old('tanggal_selesai') }}"
                                required
                            >
                        </div>
                    </div>
                    <small class="form-hint">Rentang waktu pelaksanaan ujian</small>
                    @error('tanggal_mulai')
                        <small class="form-hint" style="color: #f44336;">{{ $message }}</small>
                    @enderror
                    @error('tanggal_selesai')
                        <small class="form-hint" style="color: #f44336;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kuota_peserta">Kouta Peserta</label>
                        <input 
                            type="number" 
                            id="kuota_peserta"
                            name="kuota_peserta" 
                            class="form-input" 
                            placeholder="Contoh : 100"
                            value="{{ old('kuota_peserta') }}"
                            min="1"
                        >
                        <small class="form-hint">Maksimal peserta gelombang ini</small>
                        @error('kuota_peserta')
                            <small class="form-hint" style="color: #f44336;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">
                            Status <span class="required">*</span>
                        </label>
                        <select 
                            id="status"
                            name="status" 
                            class="form-input" 
                            required
                        >
                            <option value="">Pilih status</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <small class="form-hint">Status pendaftaran gelombang</small>
                        @error('status')
                            <small class="form-hint" style="color: #f44336;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('jadwal-ujian-admin') }}" class="btn-form btn-cancel">BATAL</a>
                <button type="submit" class="btn-form btn-submit">SIMPAN</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Validasi tanggal
document.querySelector('input[name="tanggal_selesai"]').addEventListener('change', function() {
    const tanggalMulai = document.querySelector('input[name="tanggal_mulai"]').value;
    const tanggalSelesai = this.value;
    
    if (tanggalMulai && tanggalSelesai) {
        if (new Date(tanggalSelesai) < new Date(tanggalMulai)) {
            alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai!');
            this.value = '';
        }
    }
});

// Konfirmasi sebelum submit
document.querySelector('form').addEventListener('submit', function(e) {
    const namaGelombang = document.querySelector('input[name="nama_gelombang"]').value;
    
    if (!confirm(`Apakah Anda yakin ingin menambahkan "${namaGelombang}"?`)) {
        e.preventDefault();
    }
});
</script>
@endpush