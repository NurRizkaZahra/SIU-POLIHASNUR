<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    { 
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
    public function edit()
{
    $user = Auth::user();
    return view('admin.profile.edit', compact('user'));
}

public function update(Request $request)
{
    // Logic update profile
}

public function changePassword()
{
    return view('admin.profile.change-password');
}
}
