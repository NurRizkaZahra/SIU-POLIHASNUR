@extends('layouts.app-admin')

@section('title', 'Edit Profile Admin')
@section('page-title', 'EDIT PROFILE ADMIN')

@section('content')
    <style>
        .profile-container {
            padding: 20px;
        }

        .profile-wrapper {
            background: #f5f7fa;
            padding: 20px;
            border-radius: 15px;
        }

        .profile-header {
            background: linear-gradient(135deg, #1e5a9e 0%, #2b6cb0 100%);
            border-radius: 12px 12px 0 0;
            padding: 40px 30px 80px 30px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(250, 204, 21, 0.1);
            border-radius: 50%;
        }

        .profile-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .left-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .avatar-container {
            position: relative;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            background: white;
        }

        .avatar-overlay {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 34px;
            height: 34px;
            background: #fbbf24;
            border-radius: 50%;
            border: 3px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .avatar-overlay:hover {
            background: #f59e0b;
            transform: scale(1.1);
        }

        .avatar-overlay svg {
            width: 16px;
            height: 16px;
            color: #78350f;
        }

        .user-info {
            color: white;
        }

        .user-name {
            font-size: 32px;
            font-weight: bold;
            margin: 0 0 12px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .badges-container {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .badge-admin {
            background: #fbbf24;
            color: #1e293b;
        }

        .header-label {
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
            font-weight: 500;
            margin: 0 0 4px 0;
        }

        .profile-body {
            background: white;
            border: none;
            border-radius: 0 0 12px 12px;
            padding: 60px 30px 30px 30px;
            margin-top: -40px;
            position: relative;
        }

        /* Alert Messages */
        .alert {
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* Form Sections */
        .info-section {
            background: #ffffff;
            border: 2px solid #2b6cb0;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(43, 108, 176, 0.1);
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e5e7eb;
        }

        .title-icon {
            width: 24px;
            height: 24px;
            color: #2b6cb0;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px 30px;
        }

        .form-grid.full-width {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-label .required {
            color: #ef4444;
            margin-left: 3px;
        }

        .form-control {
            font-size: 15px;
            color: #1e293b;
            font-weight: 500;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            background: #f8fafc;
            transition: all 0.2s;
            outline: none;
            width: 100%;
            box-sizing: border-box;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: #2b6cb0;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.12);
        }

        .form-control:disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
        }

        .invalid-feedback {
            font-size: 12px;
            color: #ef4444;
            margin-top: 2px;
        }

        .form-hint {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon .form-control {
            padding-left: 40px;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #94a3b8;
            pointer-events: none;
        }

        /* Password Toggle */
        .input-with-toggle {
            position: relative;
        }

        .input-with-toggle .form-control {
            padding-right: 42px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            color: #94a3b8;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #2b6cb0;
        }

        .toggle-password svg {
            width: 18px;
            height: 18px;
        }

        /* Avatar Upload */
        .avatar-upload-section {
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1.5px dashed #cbd5e1;
            transition: all 0.2s;
        }

        .avatar-upload-section:hover {
            border-color: #2b6cb0;
            background: #f0f7ff;
        }

        .avatar-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #2b6cb0;
            object-fit: cover;
            flex-shrink: 0;
            background: white;
        }

        .upload-info {
            flex: 1;
        }

        .upload-info p {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: #64748b;
        }

        .btn-upload {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #2b6cb0;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-upload:hover {
            background: #1e5a9e;
        }

        .btn-upload svg {
            width: 16px;
            height: 16px;
        }

        input[type="file"] {
            display: none;
        }

        /* Footer Actions */
        .footer-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: #2b6cb0;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid #2b6cb0;
            transition: all 0.3s;
            font-size: 15px;
        }

        .btn-back:hover {
            background: #2b6cb0;
            color: white;
            transform: translateX(-5px);
            box-shadow: 0 4px 12px rgba(43, 108, 176, 0.3);
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #2b6cb0;
            color: white;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 600;
            border: 2px solid #2b6cb0;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(43, 108, 176, 0.3);
        }

        .btn-save:hover {
            background: #1e5a9e;
            border-color: #1e5a9e;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(43, 108, 176, 0.4);
        }

        .btn-icon {
            width: 18px;
            height: 18px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: 1;
            }
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 10px;
            }

            .profile-wrapper {
                padding: 10px;
            }

            .profile-header {
                padding: 30px 20px 70px 20px;
            }

            .header-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .left-section {
                flex-direction: column;
            }

            .user-name {
                font-size: 24px;
            }

            .badges-container {
                justify-content: center;
            }

            .profile-body {
                padding: 50px 20px 20px 20px;
            }

            .footer-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .btn-back,
            .btn-save {
                justify-content: center;
            }

            .avatar-upload-section {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>

    <div class="profile-container">
        <div class="profile-wrapper">

            <!-- Profile Header -->
            <div class="profile-header">
                <div class="header-content">
                    <div class="left-section">
                        <div class="avatar-container">
                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.png') }}"
                                alt="Profile Photo" class="avatar" id="headerAvatar">
                            <label for="photoInput" class="avatar-overlay" title="Ganti Foto">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                        </div>

                        <div class="user-info">
                            <p class="header-label">Sedang mengedit profil</p>
                            <h1 class="user-name">{{ $user->name }}</h1>
                            <div class="badges-container">
                                <span class="badge badge-admin">
                                    ★ Administrator
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Body -->
            <div class="profile-body">

                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Terdapat kesalahan. Harap periksa kembali isian form.
                    </div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                    id="editProfileForm">
                    @csrf
                    @method('PUT')

                    {{-- Input file tersembunyi --}}
                    <input type="file" id="photoInput" name="photo" accept="image/*">

                    <!-- Section: Foto Profil -->
                    <div class="info-section">
                        <div class="section-title">
                            <svg class="title-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Foto Profil
                        </div>

                        <div class="avatar-upload-section">
                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.png') }}"
                                alt="Preview Foto" class="avatar-preview" id="avatarPreview">
                            <div class="upload-info">
                                <p>Upload foto profil baru. Format yang didukung: JPG, PNG, GIF. Ukuran maksimal 2MB.</p>
                                <label for="photoInput" class="btn-upload">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    Pilih Foto
                                </label>
                                <span id="fileName" style="font-size: 13px; color: #64748b; margin-left: 10px;"></span>
                                @error('photo')
                                    <p class="invalid-feedback d-block">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Informasi Personal -->
                    <div class="info-section">
                        <div class="section-title">
                            <svg class="title-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informasi Personal
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    Nama Lengkap
                                    <span class="required">*</span>
                                </label>
                                <div class="input-with-icon">
                                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <input type="text" name="name"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap"
                                        required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Email
                                    <span class="required">*</span>
                                </label>
                                <div class="input-with-icon">
                                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <input type="email" name="email"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                        value="{{ old('email', $user->email) }}" placeholder="Masukkan email" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Role</label>
                                <div class="input-with-icon">
                                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <input type="text" class="form-control" value="Administrator" disabled>
                                </div>
                                <span class="form-hint">Role tidak dapat diubah.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Keamanan Akun -->
                    <div class="info-section">
                        <div class="section-title">
                            <svg class="title-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Keamanan Akun
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Password Saat Ini</label>
                                <div class="input-with-icon input-with-toggle">
                                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <input type="password" name="current_password" id="currentPassword"
                                        class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                        placeholder="Masukkan password saat ini">
                                    <button type="button" class="toggle-password"
                                        onclick="togglePassword('currentPassword', this)">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-eye">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="form-hint">Wajib diisi hanya jika ingin mengganti password.</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <div class="input-with-icon input-with-toggle">
                                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    <input type="password" name="password" id="newPassword"
                                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        placeholder="Masukkan password baru">
                                    <button type="button" class="toggle-password"
                                        onclick="togglePassword('newPassword', this)">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-eye">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="form-hint">Minimal 8 karakter.</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <div class="input-with-icon input-with-toggle">
                                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <input type="password" name="password_confirmation" id="confirmPassword"
                                        class="form-control" placeholder="Konfirmasi password baru">
                                    <button type="button" class="toggle-password"
                                        onclick="togglePassword('confirmPassword', this)">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-eye">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <span class="form-hint">Ulangi password baru untuk konfirmasi.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="footer-actions">
                        <a href="{{ route('admin.profile') }}" class="btn-back">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="btn-save">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview foto saat file dipilih
        document.getElementById('photoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('avatarPreview').src = ev.target.result;
                document.getElementById('headerAvatar').src = ev.target.result;
            };
            reader.readAsDataURL(file);

            document.getElementById('fileName').textContent = file.name;
        });

        // Toggle show/hide password
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            const svg = btn.querySelector('svg');
            if (isPassword) {
                svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
            } else {
                svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
            }
        }
    </script>
@endsection
