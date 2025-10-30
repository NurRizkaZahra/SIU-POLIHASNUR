@extends('layouts.app-admin')

@section('title', 'Detail Pendaftar')
@section('page-title', 'DETAIL PENDAFTAR')

@section('content')
<style>
    .pendaftaran-container {
        max-width: 1000px;
        margin: 15px auto;
        padding: 20px;
    }

    .form-title {
        text-align: center;
        color: #1e5a96;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 30px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .form-section {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 2px solid #1e5a96;
    }

    .section-title {
        background: #1e5a96;
        color: white;
        padding: 12px 20px;
        margin: -30px -30px 25px -30px;
        font-weight: 600;
        font-size: 18px;
        border-radius: 10px 10px 0 0;
    }

    .section-divider {
        border: 0;
        height: 2px;
        background: #1e5a96;
        margin: 30px 0 20px 0;
    }

    .data-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 12px;
    }

    .data-item {
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 12px 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .data-item strong {
        display: block;
        color: #1e5a96;
        margin-bottom: 6px;
        font-size: 14px;
    }

    .data-item span {
        color: #333;
        font-size: 15px;
    }

    .btn-back {
        background: #1e5a96;
        color: white;
        padding: 10px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
        margin-top: 40px;
    }

    .btn-back:hover {
        background: #0d3d6b;
        transform: translateY(-2px);
        color: white;
    }
</style>

<div class="pendaftaran-container">
    <div class="form-section">
        <div class="section-title">INFORMASI LENGKAP PENDAFTAR</div>

        {{-- DATA DIRI --}}
        <h5 style="color: #1e5a96; font-weight: 600; margin-bottom: 15px; font-size: 17px;">Data Diri</h5>
        <div class="data-row">
            <div class="data-item">
                <strong>Nama Lengkap:</strong>
                <span>{{ $camaba->personalData->full_name ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>NIK:</strong>
                <span>{{ $camaba->personalData->nik ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item">
                <strong>Tempat Lahir:</strong>
                <span>{{ $camaba->personalData->place_of_birth ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>Tanggal Lahir:</strong>
                <span>{{ $camaba->personalData->date_of_birth ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item">
                <strong>Jenis Kelamin:</strong>
                <span>{{ $camaba->personalData->gender ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>Agama:</strong>
                <span>{{ $camaba->personalData->religion ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item">
                <strong>No. KK:</strong>
                <span>{{ $camaba->personalData->kk_number ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>No. Telepon:</strong>
                <span>{{ $camaba->personalData->phone ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item" style="grid-column: 1 / -1;">
                <strong>Alamat Lengkap:</strong>
                <span>{{ $camaba->personalData->address ?? '-' }}</span>
            </div>
        </div>

        <hr class="section-divider">

        {{-- PENDIDIKAN --}}
        <h5 style="color: #1e5a96; font-weight: 600; margin-bottom: 15px; font-size: 17px;">Pendidikan</h5>
        <div class="data-row">
            <div class="data-item">
                <strong>Sekolah Asal:</strong>
                <span>{{ $camaba->educationData->school_name ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>NPSN:</strong>
                <span>{{ $camaba->educationData->school_code ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item">
                <strong>NISN:</strong>
                <span>{{ $camaba->educationData->nisn ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>Jurusan:</strong>
                <span>{{ $camaba->educationData->major ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item">
                <strong>Tahun Masuk:</strong>
                <span>{{ $camaba->educationData->year_of_entry ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>Prestasi:</strong>
                <span>{{ $camaba->educationData->achievement ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item" style="grid-column: 1 / -1;">
                <strong>Alamat Sekolah:</strong>
                <span>{{ $camaba->educationData->school_address ?? '-' }}</span>
            </div>
        </div>

        <hr class="section-divider">

        {{-- KELUARGA --}}
        <h5 style="color: #1e5a96; font-weight: 600; margin-bottom: 15px; font-size: 17px;">Data Keluarga</h5>
        <div class="data-row">
            <div class="data-item">
                <strong>Nama Ayah:</strong>
                <span>{{ $camaba->familyData->father_name ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>Pekerjaan Ayah:</strong>
                <span>{{ $camaba->familyData->father_job ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item">
                <strong>Nama Ibu:</strong>
                <span>{{ $camaba->familyData->mother_name ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>Pekerjaan Ibu:</strong>
                <span>{{ $camaba->familyData->mother_job ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item">
                <strong>Penghasilan Orang Tua:</strong>
                <span>{{ $camaba->familyData->parent_income ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>Nomor HP Orang Tua:</strong>
                <span>{{ $camaba->familyData->parent_phone ?? '-' }}</span>
            </div>
        </div>

        <div class="data-row">
            <div class="data-item">
                <strong>Jumlah Anak:</strong>
                <span>{{ $camaba->familyData->number_of_children ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>Anak Ke:</strong>
                <span>{{ $camaba->familyData->child_order ?? '-' }}</span>
            </div>
        </div>

        <hr class="section-divider">
        
        {{-- JALUR MASUK --}}
        <h5 style="color: #1e5a96; font-weight: 600; margin-bottom: 15px; font-size: 17px;">Jalur Masuk</h5>
        <div class="data-row">
            <div class="data-item">
                <strong>Jalur Masuk:</strong>
                <span>{{ $camaba->admissionPath->path_name ?? '-' }}</span>
            </div>
        </div>

        <hr class="section-divider">

        {{-- PROGRAM STUDI --}}
        <h5 style="color: #1e5a96; font-weight: 600; margin-bottom: 15px; font-size: 17px;">Program Studi</h5>
        <div class="data-row">
            <div class="data-item">
                <strong>Program Studi Pilihan 1:</strong>
                <span>{{ $camaba->programSelection->program1->program_name ?? '-' }}</span>
            </div>
            <div class="data-item">
                <strong>Program Studi Pilihan 2:</strong>
                <span>{{ $camaba->programSelection->program2->program_name ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Tombol kembali --}}
    <div class="mt-4 text-center">
        <a href="{{ route('admin.pendaftaran') }}" class="btn-back">← Kembali</a>
    </div>
</div>
@endsection