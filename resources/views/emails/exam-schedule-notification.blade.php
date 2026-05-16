<h2>Notifikasi Jadwal Ujian</h2>

<p>Halo, {{ $exam->user->name }}</p>

@if($status == 'approved')

<p>
    Pengajuan jadwal ujian Anda telah
    <strong>DISETUJUI</strong>.
</p>

<p>
    Gelombang:
    {{ $exam->examSchedule->wave_name ?? '-' }}
</p>

<p>
    Tanggal Ujian:
    {{ \Carbon\Carbon::parse($exam->examSchedule->exam_date)->format('d M Y') }}
</p>

@else

<p>
    Pengajuan jadwal ujian Anda telah
    <strong>DITOLAK</strong>.
</p>

@endif

<p>Terima kasih.</p>