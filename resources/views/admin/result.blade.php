@extends('layouts.app-admin')

@section('title', 'Hasil')

@section('page-title', 'HASIL')

@section('content')
<style>
.result-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 100px);
    overflow-x: hidden;
}

.result-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}

/* ===== HEADER ===== */
.result-header {
    padding: 2rem 2.5rem 1.5rem;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-bottom: 2px solid #e9ecef;
}

.result-title {
    display: flex;
    align-items: center;
    color: #1e5a96;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    line-height: 1.3;
    flex-wrap: wrap;
}

.result-subtitle {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 0;
    line-height: 1.5;
    
}

/* ===== ACTION BAR ===== */
.action-bar {
    padding: 1.25rem 2.5rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.search-wrapper {
    flex: 1;
    min-width: 260px;
    position: relative;
}

.search-input {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 3rem;
    border: 2px solid #dee2e6;
    border-radius: 12px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
}

.search-input:focus {
    outline: none;
    border-color: #1e5a96;
    box-shadow: 0 0 0 4px rgba(30, 90, 150, 0.1);
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1.1rem;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

/* ===== BUTTON ===== */
.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.7rem 1.4rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-excel {
    background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
}

.btn-print {
    background: linear-gradient(135deg, #1e5a96 0%, #2471b9 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(30, 90, 150, 0.3);
}

.btn-action:hover {
    transform: translateY(-2px);
    color: white;
}

/* ===== TABLE ===== */
.table-container {
    padding: 1.5rem 2.5rem 2rem;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
}

/* Scrollbar */
.table-container::-webkit-scrollbar {
    height: 8px;
}

.table-container::-webkit-scrollbar-thumb {
    background: #c7d2e0;
    border-radius: 10px;
}

.table-container::-webkit-scrollbar-track {
    background: #edf2f7;
}

.result-table {
    width: 100%;
    min-width: 850px;
    border-collapse: separate;
    border-spacing: 0;
}

/* Jangan pecah text */
.result-table th,
.result-table td {
    white-space: nowrap;
}

/* Nama & sekolah boleh multiline */
.col-name,
.col-school {
    white-space: normal !important;
}

/* Lebar kolom */
.result-table colgroup col:nth-child(1) { width: 80px; }
.result-table colgroup col:nth-child(2) { width: 260px; }
.result-table colgroup col:nth-child(3) { width: 260px; }
.result-table colgroup col:nth-child(4) { width: 130px; }
.result-table colgroup col:nth-child(5) { width: 150px; }
.result-table colgroup col:nth-child(6) { width: 120px; }

/* ===== TABLE HEAD ===== */
.result-table thead {
    background: linear-gradient(135deg, #1e5a96 0%, #2471b9 100%);
}

.result-table thead th {
    padding: 1rem 1.25rem;
    color: white;
    font-weight: 600;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    border: none;
    vertical-align: middle;
}

.result-table thead th:first-child {
    border-radius: 12px 0 0 0;
}

.result-table thead th:last-child {
    border-radius: 0 12px 0 0;
}

/* ===== TABLE BODY ===== */
.result-table tbody tr {
    transition: background 0.2s ease;
}

.result-table tbody tr:hover {
    background: #f4f8fd;
}

.result-table tbody tr:not(:last-child) td {
    border-bottom: 1px solid #f0f2f5;
}

.result-table tbody td {
    padding: 1rem 1.25rem;
    border: none;
    vertical-align: middle;
}

/* ===== ALIGN ===== */
.result-table th.col-no,
.result-table th.col-pu,
.result-table th.col-psi,
.result-table th.col-iq,
.result-table td.col-no,
.result-table td.col-pu,
.result-table td.col-psi,
.result-table td.col-iq {
    text-align: center;
}

.result-table th.col-name,
.result-table th.col-school,
.result-table td.col-name,
.result-table td.col-school {
    text-align: left;
}

/* ===== TEXT ===== */
.name-text {
    font-weight: 600;
    font-size: 1rem;
    color: #2c3e50;
    line-height: 1.5;
    word-break: break-word;
}

.school-text {
    font-weight: 500;
    font-size: 0.93rem;
    color: #555;
    line-height: 1.5;
    word-break: break-word;
}

/* ===== BADGE ===== */
.number-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #78350f;
    font-weight: 700;
    font-size: 1rem;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(251, 191, 36, 0.3);
}

.score-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.55rem 1rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1rem;
    min-width: 75px;
}

.score-pu,
.score-psi,
.score-iq {
    background: linear-gradient(135deg, #1e5a96 0%, #2471b9 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(30, 90, 150, 0.25);
}

/* ===== FOOTER ===== */
.result-footer {
    padding: 1.25rem 2.5rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    text-align: center;
}

.footer-text {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
}

/* ===== EMPTY ===== */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-icon {
    font-size: 4.5rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.4rem;
}

.empty-subtitle {
    font-size: 0.9rem;
    color: #adb5bd;
}

/* ===== RESPONSIVE ===== */

@media (max-width: 768px) {

    .result-container {
        padding: 1rem;
    }

    .result-header,
    .action-bar,
    .table-container,
    .result-footer {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .result-title {
        font-size: 1.4rem;
    }

    .result-subtitle {
        font-size: 0.85rem;
    }

    .action-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .search-wrapper {
        width: 100%;
        min-width: 100%;
    }

    .action-buttons {
        width: 100%;
        flex-direction: column;
    }

    .btn-action {
        width: 100%;
        justify-content: center;
    }

    .result-table {
        min-width: 850px;
    }
}

@media (max-width: 480px) {

    .result-container {
        padding: 0.75rem;
    }

    .result-card {
        border-radius: 12px;
    }

    .result-header {
        padding-top: 1.25rem;
        padding-bottom: 1rem;
    }

    .result-title {
        font-size: 1.15rem;
    }

    .result-subtitle {
        font-size: 0.8rem;
    }

    .search-input {
        font-size: 0.85rem;
    }

    .btn-action {
        font-size: 0.82rem;
        padding: 0.75rem 1rem;
    }

    .number-badge {
        width: 34px;
        height: 34px;
        font-size: 0.85rem;
    }

    .score-badge {
        min-width: 60px;
        font-size: 0.85rem;
        padding: 0.45rem 0.7rem;
    }

    .footer-text {
        font-size: 0.8rem;
    }

    .empty-state {
        padding: 3rem 1rem;
    }

    .empty-icon {
        font-size: 3.5rem;
    }

    .empty-title {
        font-size: 1rem;
    }

    .empty-subtitle {
        font-size: 0.82rem;
    }
}

/* ===== PRINT ===== */
@media print {

    .result-container {
        padding: 0;
        background: white;
    }

    .action-bar {
        display: none !important;
    }

    .result-card {
        box-shadow: none;
        border-radius: 0;
    }

    .result-header {
        background: white;
        border-bottom: 2px solid #000;
    }

    .table-container {
        overflow: visible;
        padding: 0 1.5rem 1.5rem;
    }

    .result-table {
        min-width: 100%;
    }

    .result-table thead {
        background: #1e5a96 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .number-badge,
    .score-badge {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .result-table tbody tr:hover {
        background: none;
    }

    tr {
        page-break-inside: avoid;
    }
}
</style>

<div class="result-container">
    <div class="result-card">

        {{-- HEADER --}}
        <div class="result-header">
            <h1 class="result-title">
                <i class="bi bi-graph-up-arrow"></i>
                Hasil Ujian
            </h1>
            <p class="result-subtitle">
                Daftar hasil penilaian peserta ujian seleksi
            </p>
        </div>

        {{-- ACTION BAR --}}
        <div class="action-bar">
            <div class="search-wrapper">
                <i class="bi bi-search search-icon"></i>
                <input
                    type="text"
                    class="search-input"
                    id="searchInput"
                    placeholder="Ketik nama peserta untuk mencari..."
                >
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.results.excel') }}" class="btn-action btn-excel">
                    <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                    <span>Export Excel</span>
                </a>
                <button onclick="window.print()" class="btn-action btn-print">
                    <i class="bi bi-printer-fill"></i>
                    <span>Cetak</span>
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="table-container">
            <table class="result-table">
                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-name">Nama Peserta</th>
                        <th class="col-school">Asal Sekolah</th>
                        <th class="col-pu">Nilai PU</th>
                        <th class="col-psi">Nilai Psikotes</th>
                        <th class="col-iq">IQ</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse ($exams as $i => $exam)
                        <tr class="table-row">
                            <td class="col-no">
                                <span class="number-badge">{{ $i + 1 }}</span>
                            </td>
                            <td class="col-name">
                                <span class="name-text">{{ $exam['name'] }}</span>
                            </td>
                            <td class="col-school">
                                <span class="school-text">{{ $exam['school'] ?? '-' }}</span>
                            </td>
                            <td class="col-pu">
                                <span class="score-badge score-pu">{{ $exam['pu'] }}</span>
                            </td>
                            <td class="col-psi">
                                <span class="score-badge score-psi">{{ $exam['psi_score'] }}</span>
                            </td>
                            <td class="col-iq">
                                <span class="score-badge score-iq">{{ $exam['iq'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-inbox empty-icon"></i>
                                    <p class="empty-title">Belum ada hasil ujian</p>
                                    <p class="empty-subtitle">Data akan muncul setelah peserta menyelesaikan ujian</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- FOOTER --}}
        @if(count($exams) > 0)
        <div class="result-footer">
            <p class="footer-text" id="showingText">
                <i class="bi bi-info-circle me-1"></i>
                Menampilkan <strong>{{ count($exams) }}</strong> dari <strong>{{ count($exams) }}</strong> peserta
            </p>
        </div>
        @endif

    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const allRows = Array.from(tableBody.querySelectorAll('.table-row'));
    const totalData = allRows.length;

    if (totalData === 0) return;

    searchInput.addEventListener('input', function (e) {
        const term = e.target.value.toLowerCase().trim();
        let visible = 0;

        allRows.forEach(row => {
            const name = row.querySelector('.name-text');
            if (name && name.textContent.toLowerCase().includes(term)) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        const showingText = document.getElementById('showingText');
        if (showingText) {
            showingText.innerHTML = `
                <i class="bi bi-info-circle me-1"></i>
                Menampilkan <strong>${visible}</strong> dari <strong>${totalData}</strong> peserta
            `;
        }

        const existing = document.getElementById('noResults');
        if (visible === 0) {
            if (!existing) {
                const row = document.createElement('tr');
                row.id = 'noResults';
                row.innerHTML = `
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-search empty-icon"></i>
                            <p class="empty-title">Tidak ada hasil yang ditemukan</p>
                            <p class="empty-subtitle">Coba kata kunci pencarian yang lain</p>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            }
        } else {
            if (existing) existing.remove();
        }
    });
});
</script>
@endsection