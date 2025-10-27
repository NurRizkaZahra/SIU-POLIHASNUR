@extends('layouts.app-admin')

@section('title', 'SIU-POLIHASNUR - Pendaftaran')
@section('page-title', 'PENDAFTARAN')

@push('styles')
<style>
    .pendaftaran-wrapper {
        padding: 20px;
        background: #f8f9fa;
        min-height: calc(100vh - 160px);
    }

    /* Header dengan tombol cetak */
    .page-header {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .btn-print {
        padding: 12px 24px;
        background: linear-gradient(135deg, #1e5a9e, #2874ba);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 90, 158, 0.3);
    }

    /* Table Container */
    .table-container {
        background: white;
        border: 2px solid #2c3e50;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
        background: #f8f9fa;
    }

    .data-table th {
        padding: 16px;
        text-align: center;
        font-weight: 700;
        color: #2c3e50;
        font-size: 15px;
        border-right: 2px solid #2c3e50;
        border-bottom: 2px solid #2c3e50;
    }

    .data-table th:last-child {
        border-right: none;
    }

    .data-table tbody tr {
        border-bottom: 2px solid #2c3e50;
    }

    .data-table tbody tr:last-child {
        border-bottom: none;
    }

    .data-table td {
        padding: 16px;
        color: #333;
        text-align: center;
        border-right: 2px solid #2c3e50;
        min-height: 100px;
    }

    .data-table td:first-child {
        font-weight: 600;
    }

    .data-table td:last-child {
        border-right: none;
    }

    /* Column widths */
    .data-table th:nth-child(1),
    .data-table td:nth-child(1) {
        width: 60px;
    }

    .data-table th:nth-child(2),
    .data-table td:nth-child(2) {
        width: 25%;
        text-align: left;
    }

    .data-table th:nth-child(3),
    .data-table td:nth-child(3) {
        width: 20%;
    }

    .data-table th:nth-child(4),
    .data-table td:nth-child(4) {
        width: 25%;
    }

    .data-table th:nth-child(5),
    .data-table td:nth-child(5) {
        width: auto;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 8px 20px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-view {
        background: linear-gradient(135deg, #1e5a9e, #2874ba);
        color: white;
        box-shadow: 0 2px 4px rgba(30, 90, 158, 0.2);
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(30, 90, 158, 0.3);
    }

    /* Empty State */
    .empty-state {
        padding: 80px 20px;
        text-align: center;
    }

    .empty-icon {
        margin-bottom: 16px;
        opacity: 0.2;
    }

    .empty-text {
        font-size: 16px;
        color: #6c757d;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pendaftaran-wrapper {
            padding: 15px;
        }

        .data-table {
            font-size: 13px;
        }

        .data-table th,
        .data-table td {
            padding: 12px 8px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
        }
    }

    @media print {
        .btn-print,
        .action-buttons {
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
        <button class="btn-print" onclick="window.print()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
            </svg>
            Cetak Hasil
        </button>
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
                        <th>Pilihan Prodi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tablePendaftar">
                    <!-- Data akan dimuat di sini -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Sample data untuk testing
    const sampleData = [
        
    ];

    // Load data saat halaman dimuat
    function loadData(data = sampleData) {
        const tbody = document.getElementById('tablePendaftar');
        
        if (data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                                    <circle cx="40" cy="40" r="30" stroke="#2c3e50" stroke-width="3"/>
                                    <line x1="25" y1="25" x2="55" y2="55" stroke="#2c3e50" stroke-width="3" stroke-linecap="round"/>
                                    <line x1="55" y1="25" x2="25" y2="55" stroke="#2c3e50" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <p class="empty-text">Belum ada data pendaftar</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = data.map(item => {
            return `
                <tr>
                    <td>${item.no}</td>
                    <td>${item.nama}</td>
                    <td>${item.jalur}</td>
                    <td>${item.prodi}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action btn-view" onclick="viewDetail(${item.no})">
                                <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor" style="margin-right: 4px; vertical-align: middle;">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                                Lihat Detail
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Fungsi untuk view detail
    function viewDetail(id) {
        // Redirect ke halaman detail pendaftar
        window.location.href = '/admin/pendaftaran/' + id;
    }

    // Fungsi untuk fetch data dari server
    function fetchPendaftaran() {
        // Ganti dengan endpoint API Anda
        fetch('/api/admin/pendaftaran')
            .then(response => response.json())
            .then(data => {
                loadData(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                // Fallback ke sample data untuk testing
                loadData(sampleData);
            });
    }

    // Auto refresh data setiap 30 detik
    function startAutoRefresh() {
        setInterval(() => {
            fetchPendaftaran();
            console.log('Data diperbarui...');
        }, 30000); // 30 detik
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Load data pertama kali
        fetchPendaftaran();
        
        // Mulai auto refresh
        startAutoRefresh();
    });
</script>
@endpush