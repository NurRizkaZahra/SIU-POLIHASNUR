@extends('layouts.app')

@section('title', 'SIU-POLIHASNUR - Jadwal Ujian')

@section('page-title', 'JADWAL UJIAN')

@section('content')
<style>
    /* Override padding .content khusus halaman ini */
    .content {
        flex: 1;
        padding: 40px 50px;
        overflow-y: auto;
        background-color: #f8f9fa;
    }

    .gelombang-container {
        max-width: 900px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .gelombang-item {
        background: white;
        border: 2.5px solid #1e5a96;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(30, 90, 150, 0.1);
        transition: all 0.3s;
    }

    .gelombang-item:hover {
        box-shadow: 0 4px 15px rgba(30, 90, 150, 0.15);
        transform: translateY(-2px);
    }

    .gelombang-header {
        border-bottom: 2px solid #1e5a96;
        padding: 15px 20px;
    }

    .gelombang-title {
        color: #1e5a96;
        font-weight: 600;
        font-size: 14px;
        margin: 0;
        /* Pastikan judul tidak overflow di layar sempit */
        word-break: break-word;
    }

    .gelombang-content {
        padding: 20px;
    }

    .gelombang-input-group {
        display: flex;
        gap: 15px;
        align-items: center;
        justify-content: space-between;
    }

    .input-wrapper {
        flex: 0 0 220px;
        display: flex;
        align-items: center;
        background: white;
        border: 2.5px solid #1e5a96;
        border-radius: 25px;
        padding: 12px 20px;
        transition: all 0.3s;
    }

    .input-wrapper:focus-within {
        border-color: #ffd700;
        box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
        background: #fffef0;
    }

    .input-wrapper input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 14px;
        background: transparent;
        color: #333;
        font-weight: 500;
        width: 100%;
        /* Mencegah input date meluap di mobile */
        min-width: 0;
    }

    .input-wrapper input::placeholder {
        color: #999;
    }

    .input-wrapper input::-webkit-calendar-picker-indicator {
        cursor: pointer;
        filter: invert(0.8) sepia(0.5) saturate(1.5) hue-rotate(190deg);
    }

    .input-icon {
        width: 20px;
        height: 20px;
        color: #1e5a96;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .btn-ajukan {
        background: linear-gradient(135deg, #d4af37 0%, #ffd700 100%);
        color: #1e5a96;
        padding: 11px 35px;
        border-radius: 25px;
        border: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-ajukan:hover {
        background: linear-gradient(135deg, #ffed4e 0%, #ffffe0 100%);
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(255, 215, 0, 0.4);
    }

    .btn-ajukan:active {
        transform: translateY(-1px);
    }

    /* =====================
       RESPONSIVE — TABLET (≤ 1024px)
    ===================== */
    @media (max-width: 1024px) {
        .content {
            padding: 30px 30px;
        }

        .gelombang-container {
            max-width: 100%;
        }

        /* Input date sedikit lebih kecil agar muat berdampingan dengan tombol */
        .input-wrapper {
            flex: 0 0 200px;
        }
    }

    /* =====================
       RESPONSIVE — MOBILE (≤ 768px)
    ===================== */
    @media (max-width: 768px) {
        .content {
            padding: 20px 16px;
        }

        .gelombang-container {
            gap: 15px;
        }

        .gelombang-header {
            padding: 12px 16px;
        }

        .gelombang-title {
            font-size: 13px;
        }

        .gelombang-content {
            padding: 16px;
        }

        /* Stack input date dan tombol secara vertikal */
        .gelombang-input-group {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        /* Input wrapper full-width */
        .input-wrapper {
            flex: none;
            width: 100%;
        }

        /* Tombol full-width */
        .btn-ajukan {
            width: 100%;
            padding: 12px 20px;
        }
    }

    /* =====================
       RESPONSIVE — SMALL MOBILE (≤ 480px)
    ===================== */
    @media (max-width: 480px) {
        .content {
            padding: 16px 12px;
        }

        .gelombang-item {
            border-radius: 10px;
        }

        .gelombang-header {
            padding: 10px 14px;
        }

        .gelombang-title {
            font-size: 12px;
        }

        .gelombang-content {
            padding: 14px 12px;
        }

        .input-wrapper {
            padding: 10px 16px;
        }

        .input-wrapper input {
            font-size: 13px;
        }

        .btn-ajukan {
            font-size: 13px;
            padding: 11px 20px;
        }
    }
</style>

<div class="content">
    <div class="gelombang-container">
        @forelse($examSchedules as $item)
        <div class="gelombang-item">
            <div class="gelombang-header">
                <h3 class="gelombang-title">
                    {{ $item->wave_name }}
                    ({{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') }} -
                    {{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }})
                </h3>
            </div>
            <div class="gelombang-content">
                <div class="gelombang-input-group">
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                        </svg>
                        <input type="date"
                               class="input-jadwal"
                               data-gelombang-id="{{ $item->id }}"
                               min="{{ $item->start_date }}"
                               max="{{ $item->end_date }}">
                    </div>
                    <button class="btn-ajukan" onclick="ajukanJadwal({{ $item->id }})">Ajukan</button>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 40px; color: #999;">
            <p>Belum ada jadwal ujian yang tersedia</p>
        </div>
        @endforelse
    </div>
</div>

<script>
function ajukanJadwal(gelombangId) {
    const dateInput = document.querySelector(
        `input[data-gelombang-id="${gelombangId}"]`
    );

    if (!dateInput.value) {
        alert('Silahkan pilih tanggal terlebih dahulu');
        return;
    }

    fetch("{{ route('camaba.exam-schedule.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            exam_schedule_id: gelombangId,
            exam_date: dateInput.value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(
                'Jadwal ujian untuk tanggal ' +
                dateInput.value +
                ' telah diajukan!'
            );
            location.reload();
        } else {
            alert(data.message || 'Gagal mengajukan jadwal');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan saat mengajukan jadwal');
    });
}
</script>

@endsection