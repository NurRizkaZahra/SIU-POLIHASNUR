<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CamabaController extends Controller
{
    // Halaman Dashboard
    public function dashboard()
    {
        return view('camaba.dashboard', [
            'user' => Auth::user()
        ]);
    }

    // Upload Foto Profil
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $user = Auth::user();
        
        // Hapus foto lama jika ada
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        
        // Simpan foto baru
        $path = $request->file('photo')->store('profile-photos', 'public');
        
        // Update database menggunakan DB Query
        DB::table('users')
            ->where('id', $user->id)
            ->update(['photo' => $path]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Foto berhasil diupload',
            'path' => Storage::url($path)
        ]);
    }

    // Hapus Foto Profil
    public function deletePhoto()
    {
        $user = Auth::user();
        
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
            
            // Update database menggunakan DB Query
            DB::table('users')
                ->where('id', $user->id)
                ->update(['photo' => null]);
            
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada foto untuk dihapus'
        ]);
    }

    // Halaman Pendaftaran
    public function pendaftaran()
    {
        return view('camaba.pendaftaran');
    }

    public function simpanSementara(Request $request)
    {
        session(['data_pendaftaran' => $request->all()]);
        return redirect()->route('pendaftaran-lanjutan');
    }

    public function pendaftaranLanjutan()
    {
        $data = session('data_pendaftaran', []);

        return view('camaba.pendaftaran-lanjutan', compact('data'));
    }

    // Halaman Jadwal Ujian
    public function jadwalUjian()
    {
        return view('camaba.jadwal-ujian');
    }

    // Halaman Ujian
    public function ujian()
    {
        return view('camaba.ujian');
    }

    // Halaman Profile
    public function profile()
    {
        return view('camaba.profile', [
            'user' => Auth::user()
        ]);
    }

    // Halaman Data Diri
    public function dataDiri()
    {
        return view('camaba.data-diri');
    }

    // Halaman Info Ujian
    public function ujianInfo()
    {
        return view('camaba.ujian-info');
    }

    // Halaman Daftar Ulang
    public function daftarUlang()
    {
        return view('camaba.daftar-ulang');
    }
}