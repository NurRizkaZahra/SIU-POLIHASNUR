@extends('layouts.app-admin')

@section('title', 'SIU-POLIHASNUR - Beranda')
@section('page-title', 'BERANDA')

@push('styles')
<style>
    /* Reset untuk menghindari konflik */
    .dashboard-wrapper {
        padding: 20px;
        background: #f8f9fa;
        min-height: calc(100vh - 160px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to right, #1e5a9e, #2874ba);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(30, 90, 158, 0.2);
    }

    .stat-card-header {
        background: #fafafa;
        padding: 16px 20px;
        border-bottom: 2px solid #e0e0e0;
        font-size: 15px;
        font-weight: 600;
        color: #1e5a9e;
        text-align: center;
    }

    .stat-card-body {
        padding: 40px 20px;
        text-align: center;
        background: white;
    }

    .stat-number {
        font-size: 56px;
        font-weight: 700;
        color: #1e5a9e;
        line-height: 1;
        margin: 0 0 8px 0;
        transition: transform 0.2s ease;
    }

    .stat-label {
        font-size: 14px;
        color: #6B7280;
        font-weight: 500;
        margin: 0;
    }

    .chart-container {
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        min-height: 450px;
        overflow: hidden;
        position: relative;
    }

    .chart-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to right, #1e5a9e, #2874ba);
    }

    .chart-wrapper {
        width: 100%;
        height: 450px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #fafafa;
    }

    .chart-icon {
        margin-bottom: 16px;
        opacity: 0.3;
    }

    .chart-icon svg line {
        stroke: #1e5a9e;
    }

    .chart-label {
        font-size: 16px;
        color: #1e5a9e;
        font-weight: 500;
        margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .stat-card:last-child {
            grid-column: span 2;
        }
    }

    @media (max-width: 576px) {
        .dashboard-wrapper {
            padding: 15px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .stat-card:last-child {
            grid-column: span 1;
        }

        .stat-card-header {
            padding: 14px 16px;
            font-size: 14px;
        }

        .stat-card-body {
            padding: 30px 16px;
        }

        .stat-number {
            font-size: 44px;
        }

        .chart-container {
            min-height: 350px;
        }

        .chart-wrapper {
            height: 350px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">Total Pendaftar</div>
            <div class="stat-card-body">
                <div class="stat-number" id="totalPendaftar">0</div>
                <p class="stat-label">Pendaftar</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">Belum Ujian</div>
            <div class="stat-card-body">
                <div class="stat-number" id="belumUjian">0</div>
                <p class="stat-label">Pendaftar</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">Selesai Ujian</div>
            <div class="stat-card-body">
                <div class="stat-number" id="selesaiUjian">0</div>
                <p class="stat-label">Pendaftar</p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="chart-container">
        <div class="chart-wrapper">
            <div class="chart-icon">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="25" y1="25" x2="55" y2="55" stroke="#1e5a9e" stroke-width="3" stroke-linecap="round"/>
                    <line x1="55" y1="25" x2="25" y2="55" stroke="#1e5a9e" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
            <p class="chart-label">Grafik Statistik</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk update data dashboard
    function updateDashboardData() {
        // Simulasi fetch data dari API
        // Ganti URL dengan endpoint API Anda
        fetch('/api/dashboard-stats')
            .then(response => response.json())
            .then(data => {
                // Update angka di dashboard
                document.getElementById('totalPendaftar').textContent = data.total || 0;
                document.getElementById('belumUjian').textContent = data.belum || 0;
                document.getElementById('selesaiUjian').textContent = data.selesai || 0;
                
                // Tambahkan efek animasi
                animateNumbers();
            })
            .catch(error => {
                console.log('Menggunakan data default:', error);
            });
    }

    // Animasi untuk angka
    function animateNumbers() {
        const numbers = document.querySelectorAll('.stat-number');
        numbers.forEach(num => {
            num.style.transform = 'scale(1.1)';
            setTimeout(() => {
                num.style.transform = 'scale(1)';
            }, 200);
        });
    }

    // Update data saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        updateDashboardData();
        
        // Auto-refresh setiap 30 detik
        setInterval(updateDashboardData, 30000);
    });
</script>
@endpush