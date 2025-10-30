@extends('layouts.app-admin')

@section('title', 'SIU-POLIHASNUR - Pendaftaran')
@section('page-title', 'PENDAFTARAN')

@push('styles')
<style>
    .pendaftaran-wrapper {
        padding: 25px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: calc(100vh - 160px);
    }

    /* Header dengan tombol cetak */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        background: white;
        padding: 20px 30px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-title h2 {
        margin: 0;
        color: #1e5a96;
        font-size: 24px;
        font-weight: 700;
    }

    .header-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #1e5a9e, #2874ba);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .btn-print {
        padding: 12px 28px;
        background: linear-gradient(135deg, #1e5a9e, #2874ba);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 12px rgba(30, 90, 158, 0.3);
    }

    .btn-print:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(30, 90, 158, 0.4);
    }

    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #1e5a96;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-label {
        font-size: 13px;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1e5a96;
        margin-top: 8px;
    }

    /* Table Container */
    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
    }

    .data-table thead {
        background: linear-gradient(135deg, #1e5a9e, #2874ba);
    }

    .data-table th {
        padding: 18px 16px;
        text-align: left;
        font-weight: 700;
        color: white;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 3px solid #0d3d6b;
    }

    .data-table th:first-child {
        text-align: center;
        border-radius: 15px 0 0 0;
    }

    .data-table th:last-child {
        text-align: center;
        border-radius: 0 15px 0 0;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .data-table tbody tr:last-child {
        border-bottom: none;
    }

    .data-table td {
        padding: 18px 16px;
        color: #333;
        vertical-align: middle;
    }

    .data-table td:first-child {
        text-align: center;
        font-weight: 700;
        color: #1e5a96;
        font-size: 16px;
    }

    .data-table td:last-child {
        text-align: center;
    }

    /* Student Name styling */
    .student-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 15px;
    }

    /* Badge for Jalur Masuk */
    .badge-jalur {
        display: inline-block;
        padding: 6px 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Program badge */
    .badge-program {
        display: inline-block;
        padding: 6px 14px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Action button */
    .btn-view {
        padding: 10px 22px;
        background: linear-gradient(135deg, #1e5a9e, #2874ba);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 3px 8px rgba(30, 90, 158, 0.2);
        text-decoration: none;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(30, 90, 158, 0.3);
        color: white;
    }

    /* Empty State */
    .empty-state {
        padding: 80px 20px;
        text-align: center;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.3;
    }

    .empty-text {
        font-size: 18px;
        color: #6c757d;
        margin: 0;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pendaftaran-wrapper {
            padding: 15px;
        }

        .page-header {
            flex-direction: column;
            gap: 15px;
        }

        .data-table {
            font-size: 13px;
        }

        .data-table th,
        .data-table td {
            padding: 12px 8px;
        }

        .stat-value {
            font-size: 24px;
        }
    }

    @media print {
        .btn-print,
        .btn-view,
        .stats-container {
            display: none !important;
        }

        .pendaftaran-wrapper {
            padding: 0;
            background: white;
        }

        .table-container {
            box-shadow: none;
        }
    }
</style>
@endpush

@section('content')
<div class="pendaftaran-wrapper">
    <!-- Header dengan tombol cetak -->
    <div class="page-header">
        <div class="header-title">
            <div class="header-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                </svg>
            </div>
            <h2>Data Pendaftar</h2>
        </div>
        <button class="btn-print" onclick="window.print()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
            </svg>
            Cetak Hasil
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-label">Total Pendaftar</div>
            <div class="stat-value">{{ $camaba->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Tahun Akademik</div>
            <div class="stat-value" style="font-size: 24px;">2025/2026</div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Jalur Masuk</th>
                        <th>Program Studi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tablePendaftar">
                    @forelse ($camaba as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <span class="student-name">{{ $item->personalData->full_name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge-jalur">{{ $item->admissionPath->path_name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge-program">{{ $item->programSelection->program1->program_name ?? '-' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.pendaftaran.show', $item->id) }}" class="btn-view">
                                    <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">📋</div>
                                    <p class="empty-text">Belum ada data pendaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection