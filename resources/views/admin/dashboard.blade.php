@extends('layouts.app-admin')

@section('title', 'SIU-POLIHASNUR - Beranda')
@section('page-title', 'BERANDA')

@push('styles')
<style>
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

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .stat-card:last-child {
            grid-column: span 2;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .stat-number {
            font-size: 44px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">

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

    {{-- BAR CHART --}}
    <div class="card p-4 shadow-sm">
        <canvas id="ujianChart" height="120"></canvas>
    </div>

</div>
@endsection

@push('scripts')

<!-- CHART.JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // FETCH DATA
    function updateDashboardData() {
        fetch("{{ url('/admin/dashboard/stats') }}", {
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": csrf,
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            animateCounter("totalPendaftar", data.total ?? 0);
            animateCounter("belumUjian", data.belum ?? 0);
            animateCounter("selesaiUjian", data.selesai ?? 0);

            updateChart(data.total ?? 0, data.selesai ?? 0, data.belum ?? 0);
        })
        .catch(err => console.error("Fetch Error:", err));
    }

    // ANIMASI ANGKA
    function animateCounter(id, target) {
        const el = document.getElementById(id);
        let value = parseInt(el.innerText) || 0;
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

    // ==== BAR CHART SECTION ====

    let ujianChart = null;

    function initChart() {
        const ctx = document.getElementById('ujianChart').getContext('2d');

        ujianChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total', 'Selesai', 'Belum'],
                datasets: [{
                    label: 'Jumlah Peserta',
                    data: [0, 0, 0],
                    borderWidth: 2,
                    backgroundColor: ['#1e5a9e', '#2874ba', '#8bb9e0']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    function updateChart(total, selesai, belum) {
        if (!ujianChart) return;
        ujianChart.data.datasets[0].data = [total, selesai, belum];
        ujianChart.update();
    }

    // INITIAL LOAD
    document.addEventListener("DOMContentLoaded", () => {
        initChart();
        updateDashboardData();
        setInterval(updateDashboardData, 30000);
    });
</script>

@endpush
