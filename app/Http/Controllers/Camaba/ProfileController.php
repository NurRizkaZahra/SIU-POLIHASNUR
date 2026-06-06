<?php

namespace App\Http\Controllers\Camaba;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    { 
        $user = Auth::user();
        return view('camaba.profile', compact('user'));
    }
    public function edit()
{
    $user = Auth::user();
    return view('camaba.profile-edit', compact('user'));
}

public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Update data dasar
    $user->name = $request->name;
    $user->email = $request->email;

    // Update foto
    if ($request->hasFile('photo')) {

        // Hapus foto lama jika ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Simpan foto baru
        $photoPath = $request->file('photo')
            ->store('profile-photos', 'public');

        $user->photo = $photoPath;
    }

    // Update password jika diisi
    if ($request->filled('password')) {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.'
                ])
                ->withInput();
        }

        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()
        ->route('camaba.profile')
        ->with('success', 'Profil berhasil diperbarui.');
}

public function changePassword()
{
    return view('camaba.profile.change-password');
}
}
