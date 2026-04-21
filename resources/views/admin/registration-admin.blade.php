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

    /* Header */
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

    /* Export Dropdown */
    .export-dropdown {
        position: relative;
        display: inline-block;
    }

    .btn-export {
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

    .btn-export:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(30, 90, 158, 0.4);
    }

    .dropdown-menu-custom {
        display: none;
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        min-width: 210px;
        z-index: 1000;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .dropdown-menu-custom.show {
        display: block;
        animation: fadeDown 0.2s ease;
    }
    .info-ttl, .info-sekolah {
    font-size: 13px;
    color: #555;
    display: block;
    line-height: 1.4;
}

    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .dropdown-item-custom {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 13px 18px;
        text-align: left;
        background: none;
        border: none;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        cursor: pointer;
        transition: background 0.2s;
        border-bottom: 1px solid #f0f0f0;
        text-decoration: none;
    }

    .dropdown-item-custom:last-child {
        border-bottom: none;
    }

    .dropdown-item-custom:hover {
        background: #f0f4ff;
        color: #1e5a96;
    }

    .dropdown-item-custom .item-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .icon-excel { background: #e8f5e9; }
    .icon-print { background: #e3f2fd; }

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

    /* Table */
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

    .student-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 15px;
    }

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

    .badge-program {
        display: inline-block;
        padding: 6px 14px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

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

    /* Toast Notification */
    .toast-export {
        display: none;
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #1e5a96;
        color: white;
        padding: 14px 22px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        z-index: 9999;
        align-items: center;
        gap: 10px;
    }

    .toast-export.show {
        display: flex;
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Empty State */
    .empty-state {
        padding: 80px 20px;
        text-align: center;
    }

    .empty-icon { font-size: 64px; margin-bottom: 16px; opacity: 0.3; }
    .empty-text { font-size: 18px; color: #6c757d; margin: 0; font-weight: 500; }

    /* Responsive */
    @media (max-width: 768px) {
        .pendaftaran-wrapper { padding: 15px; }
        .page-header { flex-direction: column; gap: 15px; }
        .data-table { font-size: 13px; }
        .data-table th, .data-table td { padding: 12px 8px; }
        .stat-value { font-size: 24px; }
    }

    @media print {
        .export-dropdown, .btn-view, .stats-container { display: none !important; }
        .pendaftaran-wrapper { padding: 0; background: white; }
        .table-container { box-shadow: none; }
    }
</style>
@endpush

@section('content')
<div class="pendaftaran-wrapper">

    <!-- Header -->
    <div class="page-header">
        <div class="header-title">
            <div class="header-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                </svg>
            </div>
            <h2>Data Pendaftar</h2>
        </div>

        <!-- Tombol Export -->
        <div class="export-dropdown">
            <button class="btn-export" onclick="toggleExportDropdown(event)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                </svg>
                Export Data
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M7 10l5 5 5-5z"/>
                </svg>
            </button>
            <div class="dropdown-menu-custom" id="exportDropdown">
                <button class="dropdown-item-custom" onclick="exportExcel()">
                    <span class="item-icon icon-excel">📊</span>
                    <span>Download Excel (.xlsx)</span>
                </button>
                <button class="dropdown-item-custom" onclick="window.print()">
                    <span class="item-icon icon-print">🖨️</span>
                    <span>Cetak Langsung</span>
                </button>
            </div>
        </div>
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
            <table class="data-table" id="tablePendaftar">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Asal Sekolah</th>
                        <th>Jalur Masuk</th>
                        <th>Program Studi</th>
                        <th class="no-export">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($camaba as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <span class="student-name">{{ $item->personalData->full_name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="info ttl">
                                    {{ $item->personalData->place_of_birth ?? '-' }},
                                    {{ $item->personalData && $item->personalData->date_of_birth
                                        ? \Carbon\Carbon::parse($item->personalData->date_of_birth)->translatedFormat('d F Y')
                                        : '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="info-sekolah">{{ $item->educationData->school_name ?? '-'}}</span>
                            </td>
                            <td>
                                <span class="badge-jalur">{{ $item->admissionPath->path_name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge-program">{{ $item->programSelection->program1->program_name ?? '-' }}</span>
                            </td>
                            <td class="no-export">
                                <a href="{{ route('admin.registration.show', $item->id) }}" class="btn-view">
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

<!-- Toast Notification -->
<div class="toast-export" id="toastExport">
    <span>✅</span>
    <span id="toastMsg">File berhasil didownload!</span>
</div>
@endsection

@push('scripts')
<!-- SheetJS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    // ============================
    // Dropdown Toggle
    // ============================
    function toggleExportDropdown(e) {
        e.stopPropagation();
        document.getElementById('exportDropdown').classList.toggle('show');
    }

    document.addEventListener('click', function () {
        document.getElementById('exportDropdown').classList.remove('show');
    });

    // ============================
    // Toast Notification
    // ============================
    function showToast(msg) {
        const toast = document.getElementById('toastExport');
        document.getElementById('toastMsg').textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // ============================
    // Export Excel (.xlsx)
    // ============================
    function exportExcel() {
        document.getElementById('exportDropdown').classList.remove('show');

        const wb = XLSX.utils.book_new();

        // ── Ambil data dari tabel, skip kolom "no-export" ──
        const table   = document.getElementById('tablePendaftar');
        const headers = [];
        const rows    = [];

        // Header: skip th yang punya class no-export
        table.querySelectorAll('thead tr th').forEach(th => {
            if (!th.classList.contains('no-export')) headers.push(th.innerText.trim());
        });

        // Body rows
        table.querySelectorAll('tbody tr').forEach(tr => {
            const emptyCheck = tr.querySelector('.empty-state');
            if (emptyCheck) return; // skip empty state row

            const row = [];
            tr.querySelectorAll('td').forEach(td => {
                if (!td.classList.contains('no-export')) {
                    row.push(td.innerText.trim());
                }
            });
            if (row.length > 0) rows.push(row);
        });

        // ── Buat worksheet ──
        const wsData = [headers, ...rows];
        const ws     = XLSX.utils.aoa_to_sheet(wsData);

        // ── Lebar kolom ──
        ws['!cols'] = [
            { wch: 6  },  // No
            { wch: 35 },  // Nama Peserta
            { wch: 20 },  // Jalur Masuk
            { wch: 40 },  // Program Studi
        ];

        // ── Style header (warna biru, bold, teks putih) ──
        const headerRange = XLSX.utils.decode_range(ws['!ref']);
        for (let C = headerRange.s.c; C <= headerRange.e.c; C++) {
            const cellAddr = XLSX.utils.encode_cell({ r: 0, c: C });
            if (!ws[cellAddr]) continue;
            ws[cellAddr].s = {
                font:      { bold: true, color: { rgb: 'FFFFFF' }, name: 'Arial', sz: 12 },
                fill:      { fgColor: { rgb: '1E5A9E' } },
                alignment: { horizontal: 'center', vertical: 'center' },
                border: {
                    bottom: { style: 'medium', color: { rgb: '0D3D6B' } }
                }
            };
        }

        // ── Style baris data ──
        for (let R = 1; R <= rows.length; R++) {
            for (let C = headerRange.s.c; C <= headerRange.e.c; C++) {
                const cellAddr = XLSX.utils.encode_cell({ r: R, c: C });
                if (!ws[cellAddr]) continue;
                ws[cellAddr].s = {
                    font:      { name: 'Arial', sz: 11 },
                    alignment: { horizontal: C === 0 ? 'center' : 'left', vertical: 'center' },
                    fill:      { fgColor: { rgb: R % 2 === 0 ? 'F5F7FA' : 'FFFFFF' } },
                    border: {
                        top:    { style: 'thin', color: { rgb: 'E9ECEF' } },
                        bottom: { style: 'thin', color: { rgb: 'E9ECEF' } },
                        left:   { style: 'thin', color: { rgb: 'E9ECEF' } },
                        right:  { style: 'thin', color: { rgb: 'E9ECEF' } },
                    }
                };
            }
        }

        // ── Row height header ──
        ws['!rows'] = [{ hpt: 28 }];

        // ── Tambahkan baris info di atas (opsional) ──
        // Sheet info
        XLSX.utils.book_append_sheet(wb, ws, 'Data Pendaftar');

        // ── Sheet info ringkasan ──
        const infoData = [
            ['Laporan Data Pendaftar'],
            ['SIU-POLIHASNUR'],
            ['Tahun Akademik', '2025/2026'],
            ['Total Pendaftar', rows.length],
            ['Tanggal Cetak', new Date().toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' })],
        ];
        const wsInfo = XLSX.utils.aoa_to_sheet(infoData);
        wsInfo['!cols'] = [{ wch: 20 }, { wch: 30 }];
        wsInfo['A1'].s = { font: { bold: true, sz: 14, color: { rgb: '1E5A9E' }, name: 'Arial' } };
        wsInfo['A2'].s = { font: { bold: true, sz: 11, color: { rgb: '555555' }, name: 'Arial' } };
        XLSX.utils.book_append_sheet(wb, wsInfo, 'Info');

        // ── Download file ──
        const tanggal = new Date().toISOString().slice(0, 10);
        XLSX.writeFile(wb, `Data_Pendaftar_${tanggal}.xlsx`, { bookSST: false });

        showToast('✅ File Excel berhasil didownload!');
    }
</script>
@endpush
