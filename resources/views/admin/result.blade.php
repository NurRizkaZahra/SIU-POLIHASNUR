@extends('layouts.app-admin')

@section('title', 'Hasil')

@section('page-title', 'HASIL')

@section('content')
<style>
.result-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 100px);
}

.result-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}

.result-header {
    padding: 2rem 2.5rem 1.5rem 2.5rem;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-bottom: 2px solid #e9ecef;
}

.result-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #1e5a96;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.result-subtitle {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 0;
}

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
    min-width: 280px;
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

.btn-action {
    display: inline-flex;
    align-items: center;
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

.btn-excel:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(39, 174, 96, 0.4);
    color: white;
}

.btn-print {
    background: linear-gradient(135deg, #1e5a96 0%, #2471b9 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(30, 90, 150, 0.3);
}

.btn-print:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(30, 90, 150, 0.4);
    color: white;
}

/* ===== TABLE ===== */
.table-container {
    padding: 1.5rem 2.5rem 2rem 2.5rem;
}

.result-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    table-layout: fixed;
}

/* Lebar kolom — 6 kolom */
.result-table colgroup col:nth-child(1) { width: 75px; }
.result-table colgroup col:nth-child(2) { width: 25%; }
.result-table colgroup col:nth-child(3) { width: 25%; }
.result-table colgroup col:nth-child(4) { width: 130px; }
.result-table colgroup col:nth-child(5) { width: 150px; }
.result-table colgroup col:nth-child(6) { width: 120px; }

/* HEAD */
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
    white-space: nowrap;
}

.result-table thead th:first-child {
    border-radius: 12px 0 0 0;
}

.result-table thead th:last-child {
    border-radius: 0 12px 0 0;
}

/* Center: No, Nilai PU, Skor Psikotes, IQ */
.result-table thead th.col-no,
.result-table thead th.col-pu,
.result-table thead th.col-psi,
.result-table thead th.col-iq {
    text-align: center;
}

/* Left: Nama, Sekolah */
.result-table thead th.col-name,
.result-table thead th.col-school {
    text-align: left;
    padding-left: 1.5rem;
}

/* BODY */
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

/* Center: No, Nilai PU, Skor Psikotes, IQ */
.result-table tbody td.col-no,
.result-table tbody td.col-pu,
.result-table tbody td.col-psi,
.result-table tbody td.col-iq {
    text-align: center;
}

/* Left: Nama, Sekolah */
.result-table tbody td.col-name,
.result-table tbody td.col-school {
    text-align: left;
    padding-left: 1.5rem;
}

/* Number Badge */
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

.name-text {
    font-weight: 600;
    font-size: 1rem;
    color: #2c3e50;
}

.school-text {
    font-weight: 500;
    font-size: 0.93rem;
    color: #555;
}

/* Score Badge */
.score-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.55rem 1rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1rem;
    min-width: 75px;
    transition: transform 0.15s ease;
}

.score-badge:hover {
    transform: scale(1.05);
}

/* Biru — Nilai PU */
.score-pu {
    background: linear-gradient(135deg, #1e5a96 0%, #2471b9 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(30, 90, 150, 0.25);
}

/* Kuning — Skor Psikotes */
.score-psi {
    background: linear-gradient(135deg, #1e5a96 0%, #2471b9 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(251, 191, 36, 0.25);
}

/* Biru — IQ (sama dengan Nilai PU) */
.score-iq {
    background: linear-gradient(135deg, #1e5a96 0%, #2471b9 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(30, 90, 150, 0.25);
}

/* Footer */
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

/* Empty State */
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
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }

    .result-title {
        font-size: 1.4rem;
    }

    .action-bar {
        flex-direction: column;
    }

    .search-wrapper {
        width: 100%;
    }

    .action-buttons {
        width: 100%;
    }

    .btn-action {
        flex: 1;
        justify-content: center;
    }

    .result-table {
        font-size: 0.85rem;
        table-layout: auto;
    }

    .result-table thead th,
    .result-table tbody td {
        padding: 0.85rem 0.75rem;
    }

    .result-table thead th.col-name,
    .result-table tbody td.col-name,
    .result-table thead th.col-school,
    .result-table tbody td.col-school {
        padding-left: 0.75rem;
    }

    .number-badge {
        width: 34px;
        height: 34px;
        font-size: 0.88rem;
    }

    .score-badge {
        padding: 0.45rem 0.75rem;
        font-size: 0.88rem;
        min-width: 58px;
    }

    /* Sembunyikan Asal Sekolah & IQ di layar kecil */
    .col-school,
    .col-iq {
        display: none;
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
        padding: 1rem 1.5rem;
    }

    .table-container {
        padding: 0 1.5rem 1.5rem;
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