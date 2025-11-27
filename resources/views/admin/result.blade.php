@extends('layouts.app-admin')

@section('title', 'Hasil')

@section('page-title', 'HASIL')

@section('content')
<style>
/* Main Container */
.result-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: calc(100vh - 100px);
}

/* Card Wrapper */
.result-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}

/* Header Section */
.result-header {
    padding: 2rem 2rem 1.5rem 2rem;
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

/* Action Bar */
.action-bar {
    padding: 1.5rem 2rem;
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
    padding: 0.75rem 1rem 0.75rem 3rem;
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
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
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
}

/* Table Container */
.table-container {
    padding: 2rem;
}

.result-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

/* Table Head */
.result-table thead {
    background: linear-gradient(135deg, #1e5a96 0%, #2471b9 100%);
}

.result-table thead th {
    padding: 1.25rem 1.5rem;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
}

.result-table thead th:first-child {
    border-radius: 12px 0 0 0;
}

.result-table thead th:last-child {
    border-radius: 0 12px 0 0;
}

/* Table Body */
.result-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f0f0f0;
}

.result-table tbody tr:hover {
    background: #f8f9fa;
    transform: scale(1.002);
}

.result-table tbody tr:last-child {
    border-bottom: none;
}

.result-table tbody td {
    padding: 1.5rem 1.5rem;
    border: none;
}

/* Number Badge */
.number-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #000;
    font-weight: 700;
    font-size: 1.1rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
}

/* Name Text - NO AVATAR! */
.name-text {
    font-weight: 600;
    font-size: 1.05rem;
    color: #2c3e50;
}

/* Score Badge */
.score-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.7rem 1.5rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.1rem;
    min-width: 85px;
    transition: all 0.2s ease;
}

.score-badge:hover {
    transform: scale(1.05);
}

.score-pu {
    background: linear-gradient(135deg, #1e5a96 0%, #2471b9 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(30, 90, 150, 0.3);
}

.score-psi {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #000;
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
}

/* Footer */
.result-footer {
    padding: 1.5rem 2rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    text-align: center;
}

.footer-text {
    color: #6c757d;
    font-size: 0.95rem;
    font-weight: 500;
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-icon {
    font-size: 5rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.empty-subtitle {
    font-size: 0.95rem;
    color: #adb5bd;
}

/* Responsive */
@media (max-width: 768px) {
    .result-container {
        padding: 1rem;
    }

    .result-header,
    .action-bar,
    .table-container {
        padding: 1.5rem;
    }

    .result-title {
        font-size: 1.5rem;
    }

    .action-bar {
        flex-direction: column;
    }

    .search-wrapper {
        width: 100%;
    }

    .action-buttons {
        width: 100%;
        justify-content: stretch;
    }

    .btn-action {
        flex: 1;
        justify-content: center;
    }

    .result-table {
        font-size: 0.9rem;
    }

    .result-table thead th,
    .result-table tbody td {
        padding: 1rem;
    }

    .number-badge {
        width: 38px;
        height: 38px;
        font-size: 0.95rem;
    }

    .score-badge {
        padding: 0.6rem 1.2rem;
        font-size: 1rem;
        min-width: 75px;
    }
}

/* Print Styles */
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
    }

    .result-header {
        background: white;
        border-bottom: 2px solid #000;
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
        transform: none;
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
                <thead>
                    <tr>
                        <th class="text-center" style="width: 100px;">No</th>
                        <th style="width: auto;">Nama Peserta</th>
                        <th class="text-center" style="width: 180px;">Nilai PU</th>
                        <th class="text-center" style="width: 180px;">Nilai Psikotes</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse ($exams as $i => $exam)
                        <tr class="table-row">
                            <td class="text-center">
                                <span class="number-badge">{{ $i + 1 }}</span>
                            </td>
                            <td>
                                {{-- NO AVATAR, JUST NAME --}}
                                <span class="name-text">{{ $exam['name'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="score-badge score-pu">{{ $exam['pu'] }}</span>
                            </td>
                            <td class="text-center">
                                <span class="score-badge score-psi">{{ $exam['psi'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
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
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const allRows = Array.from(tableBody.querySelectorAll('.table-row'));
    const totalData = allRows.length;

    if (totalData > 0) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            let visibleCount = 0;

            allRows.forEach(row => {
                const nameText = row.querySelector('.name-text');
                if (nameText) {
                    const name = nameText.textContent.toLowerCase();
                    if (name.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            // Update footer text
            const showingText = document.getElementById('showingText');
            if (showingText) {
                showingText.innerHTML = `
                    <i class="bi bi-info-circle me-1"></i>
                    Menampilkan <strong>${visibleCount}</strong> dari <strong>${totalData}</strong> peserta
                `;
            }

            // Show/hide no results message
            const existingNoResults = document.getElementById('noResults');
            
            if (visibleCount === 0) {
                if (!existingNoResults) {
                    const noResultsRow = document.createElement('tr');
                    noResultsRow.id = 'noResults';
                    noResultsRow.innerHTML = `
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="bi bi-search empty-icon"></i>
                                <p class="empty-title">Tidak ada hasil yang ditemukan</p>
                                <p class="empty-subtitle">Coba kata kunci pencarian yang lain</p>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(noResultsRow);
                }
            } else {
                if (existingNoResults) {
                    existingNoResults.remove();
                }
            }
        });
    }
});
</script>
@endsection