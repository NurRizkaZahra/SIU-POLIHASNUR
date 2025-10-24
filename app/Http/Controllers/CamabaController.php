<?php

namespace App\Http\Controllers;

use App\Models\PersonalData;
use App\Models\EducationData;
use App\Models\FamilyData;
use App\Models\AdmissionPath;
use App\Models\ProgramSelection;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CamabaController extends Controller
{
    // =============================
    // DASHBOARD
    // =============================
    public function dashboard()
    {
        return view('camaba.dashboard', [
            'user' => Auth::user()
        ]);
    }

    // =============================
    // FOTO PROFIL
    // =============================
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

        // Update database
        DB::table('users')->where('id', $user->id)->update(['photo' => $path]);

        return response()->json([
            'success' => true, 
            'message' => 'Foto berhasil diupload',
            'path' => Storage::url($path)
        ]);
    }

    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
            DB::table('users')->where('id', $user->id)->update(['photo' => null]);

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

    // =============================
    // PENDAFTARAN
    // =============================
    public function pendaftaran()
    {
        return view('camaba.pendaftaran');
    }

    public function pendaftaranLanjutan()
    {
        $data = session('data_pendaftaran', []);
        return view('camaba.pendaftaran-lanjutan', compact('data'));
    }

    // =============================
    // SIMPAN DATA DIRI
    // =============================
    public function simpanDataDiri(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'religion' => 'required|string|max:50',
            'nik' => 'required|string|max:20',
            'kk_number' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        PersonalData::updateOrCreate(
            ['id_user' => Auth::id()],
            [
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'place_of_birth' => $request->place_of_birth,
                'date_of_birth' => $request->date_of_birth,
                'religion' => $request->religion,
                'nik' => $request->nik,
                'kk_number' => $request->kk_number,
                'phone' => $request->phone,
                'address' => $request->address,
            ]
        );

        return redirect()->back()->with('success', 'Data diri berhasil disimpan!');
    }

    // =============================
    // SIMPAN DATA PENDIDIKAN
    // =============================
    public function simpanDataPendidikan(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_address' => 'required|string|max:255',
            'major' => 'required|string|max:100',
            'nisn' => 'required|string|max:20',
            'school_code' => 'required|string|max:50',
            'year_of_entry' => 'required|string|max:10',
            'achievement' => 'nullable|string|max:255',
        ]);

        EducationData::updateOrCreate(
            ['id_user' => Auth::id()],
            [
                'school_name' => $request->school_name,
                'school_address' => $request->school_address,
                'major' => $request->major,
                'nisn' => $request->nisn,
                'school_code' => $request->school_code,
                'year_of_entry' => $request->year_of_entry,
                'achievement' => $request->achievement,
            ]
        );

        return redirect()->back()->with('success', 'Data pendidikan berhasil disimpan!');
    }

    // =============================
    // SIMPAN DATA KELUARGA
    // =============================
    public function simpanDataKeluarga(Request $request)
    {
        $request->validate([
            'father_name' => 'required|string|max:255',
            'father_job' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'mother_job' => 'required|string|max:255',
            'parent_income' => 'required|string|max:50',
            'number_of_children' => 'required|integer|min:1',
            'child_order' => 'required|integer|min:1',
            'parent_address' => 'required|string',
            'parent_phone' => 'required|string|max:15',
        ]);

        FamilyData::updateOrCreate(
            ['id_user' => Auth::id()],
            [
                'father_name' => $request->father_name,
                'father_job' => $request->father_job,
                'mother_name' => $request->mother_name,
                'mother_job' => $request->mother_job,
                'parent_income' => $request->parent_income,
                'number_of_children' => $request->number_of_children,
                'child_order' => $request->child_order,
                'parent_address' => $request->parent_address,
                'parent_phone' => $request->parent_phone,
            ]
        );

        return redirect()->back()->with('success', 'Data keluarga berhasil disimpan!');
    }

    // =============================
    // SIMPAN JALUR MASUK
    // =============================
    public function simpanJalurMasuk(Request $request)
    {
        $request->validate([
            'id_jalur' => 'required|exists:admission_paths,id',
        ]);

        AdmissionPath::updateOrCreate(
            ['user_id' => Auth::id()],
            ['id_jalur' => $request->id_jalur]
        );

        return back()->with('success', 'Jalur masuk berhasil disimpan!');
    }

    // =============================
    // SIMPAN PROGRAM STUDI
    // =============================
    public function simpanProgramStudi(Request $request)
    {
        $request->validate([
            'id_program_1' => 'required|different:id_program_2',
            'id_program_2' => 'nullable|different:id_program_1',
        ]);

        ProgramSelection::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'id_program_1' => $request->id_program_1,
                'id_program_2' => $request->id_program_2,
            ]
        );

        return back()->with('success', 'Pilihan program studi berhasil disimpan!');
    }

    // =============================
    // HALAMAN TAMBAHAN
    // =============================
    public function jadwalUjian()
    {
        return view('camaba.jadwal-ujian');
    }

    public function ujian()
    {
        return view('camaba.ujian');
    }

    public function profile()
    {
        return view('camaba.profile', ['user' => Auth::user()]);
    }

    public function dataDiri()
    {
        return view('camaba.data-diri');
    }

    public function ujianInfo()
    {
        return view('camaba.ujian-info');
    }

    public function daftarUlang()
    {
        return view('camaba.daftar-ulang');
    }
}
