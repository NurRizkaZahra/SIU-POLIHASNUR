@extends('layouts.app-admin')

@section('title', 'Tambah Kelompok Soal')
@section('page-title', 'TAMBAH KELOMPOK SOAL')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .required {
        color: #ef4444;
    }
    
    .form-input, .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #2b6cb0;
        box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.1);
    }
    
    .form-hint {
        font-size: 12px;
        color: #64748b;
        margin-top: 5px;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #e5e7eb;
    }
    
    .btn {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        color: white;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(43, 108, 176, 0.3);
    }
    
    .error-message {
        background: #fee2e2;
        border: 2px solid #ef4444;
        color: #dc2626;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .info-box {
        background: #dbeafe;
        border: 2px solid #3b82f6;
        color: #1e40af;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
    }
</style>

<div class="form-container">
    <div class="form-card">
        <div class="info-box">
            <strong>💡 Info:</strong>
            <p style="margin: 5px 0 0 0;">
                Kelompok soal digunakan untuk mengelompokkan soal-soal yang sejenis. 
                Untuk soal PSI (Psikotes), kelompok wajib dibuat terlebih dahulu.
            </p>
        </div>

        @if ($errors->any())
        <div class="error-message">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.question-groups.store') }}" method="POST">
            @csrf
            
            <!-- Nama Kelompok -->
            <div class="form-group">
                <label class="form-label">
                    Nama Kelompok <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-input" 
                    placeholder="Contoh: Tes Kepribadian DISC, Tes Logika Verbal"
                    value="{{ old('name') }}"
                    required>
                <div class="form-hint">Nama yang jelas dan deskriptif untuk kelompok soal ini</div>
            </div>

            <!-- Tipe Kelompok -->
            <div class="form-group">
                <label class="form-label">
                    Tipe Kelompok <span class="required">*</span>
                </label>
                <select name="type" class="form-select" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="PSI" {{ old('type') == 'PSI' ? 'selected' : '' }}>
                        Psikotes (PSI)
                    </option>
                    <option value="PU" {{ old('type') == 'PU' ? 'selected' : '' }}>
                        Pengetahuan Umum (PU)
                    </option>
                </select>
                <div class="form-hint">Pilih tipe kelompok sesuai kategori soal</div>
            </div>

            <!-- Video Tutorial -->
            <div class="form-group">
                <label class="form-label">Link Video Tutorial (Opsional)</label>
                <input 
                    type="url" 
                    name="video_tutorial" 
                    class="form-input" 
                    placeholder="https://youtube.com/watch?v=..."
                    value="{{ old('video_tutorial') }}">
                <div class="form-hint">Link video penjelasan untuk kelompok soal ini (opsional)</div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.question-groups.index') }}" class="btn btn-cancel">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="btn btn-submit">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection