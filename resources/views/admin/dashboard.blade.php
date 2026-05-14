@extends('layouts.app-admin')

@section('title', 'SIU-POLIHASNUR - Beranda')
@section('page-title', 'BERANDA')

@push('styles')
<style>
    .dashboard-wrapper {
        padding: 20px;
        background: #f8f9fa;
        min-height: calc(100vh - 160px);
        box-sizing: border-box;
    }

    /* ── Stats Grid ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
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

    /* Hover hanya desktop */
    @media (hover: hover) {
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(30,90,158,0.2);
        }
    }

    .stat-card-header {
        background: #fafafa;
        padding: 16px 20px;
        border-bottom: 2px solid #e0e0e0;
        font-size: 15px;
        font-weight: 600;
        color: #1e5a9e;
        text-align: center;
        word-break: break-word;
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
        margin: 0 0 8px;
        transition: transform 0.2s ease;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .stat-label {
        font-size: 14px;
        color: #6B7280;
        font-weight: 500;
        margin: 0;
    }

    /* ── Chart Card ── */
    .chart-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        padding: 24px 28px 20px;
        max-width: 820px;
        width: 100%;
        margin: 0 auto;
        box-sizing: border-box;
    }

    .chart-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 14px;
        border-bottom: 2px solid #e0e0e0;
    }

    .chart-card-icon {
        width: 34px;
        height: 34px;
        background: linear-gradient(135deg, #1e5a9e, #2874ba);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        flex-shrink: 0;
    }

    .chart-card-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e5a9e;
        margin: 0;
        word-break: break-word;
    }

    /* ── Chart Canvas ── */
    .chart-canvas-wrap {
        position: relative;
        width: 100%;
        height: 300px;
    }

    .chart-canvas-wrap canvas {
        position: absolute !important;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }

    /* ════════════════════════════
       TABLET
    ════════════════════════════ */
    @media (max-width: 992px) {

        .dashboard-wrapper {
            padding: 18px;
        }

        .stat-number {
            font-size: 48px;
        }

        .chart-canvas-wrap {
            height: 260px;
        }

        .chart-card {
            padding: 20px;
        }
    }

    /* ════════════════════════════
       MOBILE
    ════════════════════════════ */
    @media (max-width: 640px) {

        .dashboard-wrapper {
            padding: 16px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .stat-card-header {
            font-size: 13.5px;
            padding: 13px 16px;
        }

        .stat-card-body {
            padding: 24px 16px;
        }

        .stat-number {
            font-size: 44px;
        }

        .stat-label {
            font-size: 13px;
        }

        .chart-card {
            padding: 16px;
        }

        .chart-card-title {
            font-size: 13.5px;
        }

        .chart-card-header {
            margin-bottom: 16px;
            padding-bottom: 12px;
        }

        .chart-canvas-wrap {
            height: 240px;
        }
    }

    /* ════════════════════════════
       SMALL MOBILE
    ════════════════════════════ */
    @media (max-width: 400px) {

        .dashboard-wrapper {
            padding: 14px;
        }

        .stat-card-header {
            font-size: 13px;
            padding: 12px 14px;
        }

        .stat-card-body {
            padding: 22px 14px;
        }

        .stat-number {
            font-size: 38px;
        }

        .stat-label {
            font-size: 12px;
        }

        .chart-card {
            padding: 14px;
        }

        .chart-card-title {
            font-size: 13px;
        }

        .chart-card-icon {
            width: 30px;
            height: 30px;
            font-size: 14px;
        }

        .chart-canvas-wrap {
            height: 220px;
        }
    }

    /* ════════════════════════════
       EXTRA SMALL DEVICES
    ════════════════════════════ */
    @media (max-width: 360px) {

        .stat-card-header {
            font-size: 12px;
            padding: 12px;
        }

        .stat-number {
            font-size: 32px;
        }

        .stat-label {
            font-size: 11px;
        }

        .chart-card {
            padding: 12px;
        }

        .chart-card-title {
            font-size: 12px;
        }

        .chart-canvas-wrap {
            height: 200px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">

    {{-- Stat Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">Total Pendaftar</div>
            <div class="stat-card-body">
                <div class="stat-number" id="totalPendaftar">{{ $totalPendaftar ?? 0 }}</div>
                <p class="stat-label">Pendaftar</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">Belum Ujian</div>
            <div class="stat-card-body">
                <div class="stat-number" id="belumUjian">{{ $belumUjian ?? 0 }}</div>
                <p class="stat-label">Pendaftar</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">Selesai Ujian</div>
            <div class="stat-card-body">
                <div class="stat-number" id="selesaiUjian">{{ $selesaiUjian ?? 0 }}</div>
                <p class="stat-label">Pendaftar</p>
            </div>
        </div>
    </div>

    {{-- Bar Chart --}}
    <div class="chart-card">
        <div class="chart-card-header">
            <div class="chart-card-icon">📊</div>
            <p class="chart-card-title">Statistik Peserta Ujian</p>
        </div>
        <div class="chart-canvas-wrap">
            <canvas id="ujianChart"></canvas>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

    function updateDashboardData() {
        fetch("{{ url('/admin/dashboard/stats') }}", {
            method: "GET",
            headers: { "X-CSRF-TOKEN": csrf, "Accept": "application/json" }
        })
        .then(res => res.json())
        .then(data => {
            animateCounter("totalPendaftar", data.total   ?? 0);
            animateCounter("belumUjian",     data.belum   ?? 0);
            animateCounter("selesaiUjian",   data.selesai ?? 0);
            updateChart(data.total ?? 0, data.selesai ?? 0, data.belum ?? 0);
        })
        .catch(err => console.error("Fetch Error:", err));
    }

    function animateCounter(id, target) {
        const el   = document.getElementById(id);
        let value  = parseInt(el.innerText) || 0;
        const step = Math.max(1, Math.ceil(Math.abs(target - value) / 20));
        if (value === target) return;

        const interval = setInterval(() => {
            if (value < target) value += step;
            else value -= step;

            if ((step > 0 && value >= target) || (step < 0 && value <= target)) {
                value = target;
                clearInterval(interval);
            }

            el.innerText = value;
            el.style.transform = "scale(1.07)";
            setTimeout(() => el.style.transform = "scale(1)", 100);
        }, 30);
    }

    let ujianChart = null;

    function initChart() {
        const ctx = document.getElementById('ujianChart').getContext('2d');
        ujianChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Pendaftar', 'Selesai Ujian', 'Belum Ujian'],
                datasets: [{
                    label: 'Jumlah Peserta',
                    data: [0, 0, 0],
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                    backgroundColor: ['#1e5a9e', '#2874ba', '#8bb9e0'],
                    hoverBackgroundColor: ['#163f70', '#1a5a96', '#6a9fd0'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,  /* ikuti tinggi wrapper, bukan rasio bawaan */
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: { size: 13, weight: '600' },
                            color: '#374151',
                            padding: 16,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} orang`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 12 },
                            color: '#6B7280',
                        },
                        grid: { color: '#f0f0f0' }
                    },
                    x: {
                        ticks: {
                            font: { size: 12, weight: '600' },
                            color: '#374151',
                        },
                        grid: { display: false }
                    }
                }
            }
        });
    }

    function updateChart(total, selesai, belum) {
        if (!ujianChart) return;
        ujianChart.data.datasets[0].data = [total, selesai, belum];
        ujianChart.update();
    }

    document.addEventListener("DOMContentLoaded", () => {
        initChart();
        updateDashboardData();
        setInterval(updateDashboardData, 30000);
    });
</script>
@endpush