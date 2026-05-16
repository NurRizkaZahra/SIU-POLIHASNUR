@extends('layouts.app-admin')

@section('title', 'Edit Kelompok Soal')
@section('page-title', 'EDIT KELOMPOK SOAL')

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

    .stats-box {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
    }

    .stat-label {
        color: #64748b;
        font-size: 14px;
    }

    .stat-value {
        font-weight: 700;
        color: #1e293b;
        font-size: 16px;
    }
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 20px;
        width: 100%;
        box-sizing: border-box;
    }
    
    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
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
        line-height: 1.5;
    }
    
    .required {
        color: #ef4444;
    }
    
    .form-input,
    .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
        box-sizing: border-box;
        background: white;
    }
    
    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #2b6cb0;
        box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.1);
    }
    
    .form-hint {
        font-size: 12px;
        color: #64748b;
        margin-top: 5px;
        line-height: 1.5;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #e5e7eb;
        flex-wrap: wrap;
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
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
        box-sizing: border-box;
    }
    
    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
        color: #475569;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        color: white;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(43, 108, 176, 0.3);
        color: white;
    }
    
    .error-message {
        background: #fee2e2;
        border: 2px solid #ef4444;
        color: #dc2626;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 20px;
        overflow-wrap: break-word;
    }

    .info-box {
        background: #dbeafe;
        border: 2px solid #3b82f6;
        color: #1e40af;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        overflow-wrap: break-word;
    }

    .info-box p {
        margin: 5px 0 0 0;
        line-height: 1.6;
    }

    .stats-box {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 8px 0;
    }

    .stat-item:not(:last-child) {
        border-bottom: 1px solid #e2e8f0;
    }

    .stat-label {
        color: #64748b;
        font-size: 14px;
        line-height: 1.5;
    }

    .stat-value {
        font-weight: 700;
        color: #1e293b;
        font-size: 16px;
        text-align: right;
    }

    /* =========================
       TABLET
    ========================= */
    @media (max-width: 768px) {

        .form-container {
            padding: 16px;
        }

        .form-card {
            padding: 24px;
            border-radius: 14px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .btn {
            padding: 11px 20px;
            font-size: 14px;
        }

        .stat-label,
        .stat-value {
            font-size: 13px;
        }
    }

    /* =========================
       MOBILE
    ========================= */
    @media (max-width: 576px) {

        .form-container {
            padding: 12px;
        }

        .form-card {
            padding: 20px 16px;
            border-radius: 12px;
        }

        .form-label {
            font-size: 13px;
        }

        .form-input,
        .form-select {
            padding: 11px 13px;
            font-size: 13px;
            border-radius: 9px;
        }

        .form-hint {
            font-size: 11px;
        }

        .info-box,
        .error-message,
        .stats-box {
            padding: 12px;
        }

        .info-box,
        .error-message {
            font-size: 13px;
        }

        .stat-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }

        .stat-label,
        .stat-value {
            font-size: 13px;
            text-align: left;
        }

        .form-actions {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            font-size: 13px;
        }
    }

    /* =========================
       SMALL MOBILE
    ========================= */
    @media (max-width: 400px) {

        .form-container {
            padding: 10px;
        }

        .form-card {
            padding: 16px 14px;
        }

        .form-label {
            font-size: 12.5px;
        }

        .form-input,
        .form-select {
            font-size: 12.5px;
            padding: 10px 12px;
        }

        .btn {
            font-size: 12.5px;
            padding: 11px;
        }

        .info-box,
        .error-message,
        .stats-box {
            font-size: 12px;
        }

        .stat-label,
        .stat-value {
            font-size: 12px;
        }
    }
</style>

<div class="form-container">
    <div class="form-card">
        <div class="info-box">
            <strong>✏️ Edit Kelompok:</strong>
            <p style="margin: 5px 0 0 0;">
                Perubahan pada kelompok soal akan mempengaruhi semua soal yang terhubung dengan kelompok ini.
            </p>
        </div>

        <!-- Statistics Box -->
        <div class="stats-box">
            <div class="stat-item">
                <span class="stat-label">📝 Total Soal dalam Kelompok:</span>
                <span class="stat-value">{{ $questionGroup->questions()->count() }} soal</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">📅 Dibuat pada:</span>
                <span class="stat-value">{{ $questionGroup->created_at->format('d M Y, H:i') }}</span>
            </div>
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

        <form action="{{ route('admin.question-groups.update', $questionGroup->id) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                    value="{{ old('name', $questionGroup->name) }}"
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
                    <option value="PSI" {{ old('type', $questionGroup->type) == 'PSI' ? 'selected' : '' }}>
                        Psikotes (PSI)
                    </option>
                    <option value="PU" {{ old('type', $questionGroup->type) == 'PU' ? 'selected' : '' }}>
                        Pengetahuan Umum (PU)
                    </option>
                </select>
                <div class="form-hint">Pilih tipe kelompok sesuai kategori soal</div>
            </div>
            
            <!-- Durasi Ujian -->
<div class="form-group">
    <label class="form-label">
        Durasi (Menit) <span class="required">*</span>
    </label>
    <input 
        type="number" 
        name="duration" 
        class="form-input"
        placeholder="Contoh: 30"
        min="1"
        value="{{ old('duration', $questionGroup->duration) }}"
        required>
    <div class="form-hint">Masukkan durasi pengerjaan kelompok soal dalam menit</div>
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
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection