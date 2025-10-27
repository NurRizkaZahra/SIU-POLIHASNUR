<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalUjian;

class JadwalUjianAdminController extends Controller
{
    /**
     * Menampilkan semua jadwal ujian
     */
    public function index()
{
    // Ambil semua jadwal, urut dari terbaru
    $jadwalUjian = JadwalUjian::orderBy('tanggal_mulai', 'desc')->get();

    // Kirim ke view
    return view('admin.jadwal-ujian', compact('jadwalUjian'));
}

    /**
     * Menampilkan form tambah jadwal
     */
    public function create()
    {
        return view('admin.tambah-jadwal');
    }

    /**
     * Menyimpan jadwal baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'gelombang' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'waktu' => 'required|string|max:50',
            'lokasi' => 'required|string|max:100',
        ]);

        JadwalUjian::create([
            'gelombang' => $request->gelombang,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'lokasi' => $request->lokasi,
        ]);

        // Redirect ke route index yang benar
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal ujian berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit jadwal
     */
    public function edit($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        return view('admin.edit-jadwal', compact('jadwalujian'));
    }

    /**
     * Memperbarui data jadwal
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'gelombang' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'waktu' => 'required|string|max:50',
            'lokasi' => 'required|string|max:100',
        ]);

        $jadwal = JadwalUjian::findOrFail($id);
        $jadwal->update($request->only('gelombang', 'tanggal', 'waktu', 'lokasi'));

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal ujian berhasil diperbarui!');
    }

    /**
     * Menghapus jadwal ujian
     */
    public function destroy($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal ujian berhasil dihapus!');
    }
}
