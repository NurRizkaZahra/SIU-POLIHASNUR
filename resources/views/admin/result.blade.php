@extends('layouts.app-admin')

@section('title', 'Hasil')

@section('page-title', 'HASIL')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="bg-white shadow-sm rounded-3 p-4" style="min-height: 520px;">

        {{-- HEADER --}}
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h4 class="fw-bold mb-2">Hasil Ujian</h4>
                    <p class="text-muted mb-0" style="font-size: 1rem;">Daftar hasil penilaian peserta ujian</p>
                </div>
                
                {{-- Tombol Cetak --}}
                <div>
                    <a href="#" class="btn d-inline-flex align-items-center gap-2 px-3 py-2"
                       style="background: #1e5a96; color: white; border-radius: 8px; text-decoration: none;">
                        <i class="bi bi-printer-fill"></i>
                        Cetak Hasil
                    </a>
                </div>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">

                {{-- HEADER --}}
                <thead style="background: #1e5a96; color: white;">
                    <tr>
                        <th class="text-center py-3" style="width: 80px;">No</th>
                        <th class="py-3" style="width: 500px;">Nama Peserta</th>
                        <th class="text-center py-3" style="width: 180px;">Nilai PU</th>
                        <th class="text-center py-3" style="width: 180px;">Nilai Psikotes</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @forelse ($results as $i => $item)
                        <tr>
                            <td class="text-center">
                                <span class="badge px-3 py-2" 
                                      style="background: #fbbf24; color: #000; font-weight: 600;">
                                    {{ $i + 1 }}
                                </span>
                            </td>

                            <td>{{ $item->user->name ?? '-' }}</td>

                            <td class="text-center">
                                <span class="badge px-3 py-2" 
                                      style="background: #1e5a96; color: white; font-weight: 600;">
                                    {{ $item->nilai_pu ?? '-' }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge px-3 py-2" 
                                      style="background: #fbbf24; color: #000; font-weight: 600;">
                                    {{ $item->nilai_psikotes ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                Belum ada hasil ujian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>
@endsection