@extends('layouts.app-admin')

@section('title', 'Profile Admin')
@section('page-title', 'PROFILE ADMIN')

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
    
    .badge-dot {
        width: 8px;
        height: 8px;
        background: currentColor;
        border-radius: 50%;
        margin-right: 6px;
    }
    
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fbbf24;
        color: #78350f;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
    }
    
    .btn-edit:hover {
        background: #f59e0b;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(251, 191, 36, 0.4);
    }
    
    .btn-icon {
        width: 18px;
        height: 18px;
    }
    
    .profile-body {
        background: white;
        border: none;
        border-radius: 0 0 12px 12px;
        padding: 60px 30px 30px 30px;
        margin-top: -40px;
        position: relative;
    }
    
    .info-section {
        background: #ffffff;
        border: 2px solid #2b6cb0;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 4px rgba(43, 108, 176, 0.1);
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
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px 40px;
        margin-top: 20px;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .info-item:last-child,
    .info-item:nth-last-child(2):nth-child(odd) {
        border-bottom: none;
    }
    
    .info-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-value {
        font-size: 15px;
        color: #1e293b;
        font-weight: 500;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 13px;
        font-weight: 600;
        width: fit-content;
    }
    
    .footer-actions {
        display: flex;
        justify-content: flex-end;
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
    }
    
    .btn-back:hover {
        background: #2b6cb0;
        color: white;
        transform: translateX(-5px);
        box-shadow: 0 4px 12px rgba(43, 108, 176, 0.3);
    }
    
    @media (max-width: 992px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .info-item:nth-last-child(2):nth-child(odd) {
            border-bottom: 1px solid #f3f4f6;
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
            justify-content: center;
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
                         alt="Profile Photo" 
                         class="avatar">
                </div>
                
                <div class="user-info">
                    <h1 class="user-name">{{ $user->name }}</h1>
                    <div class="badges-container">
                        <span class="badge badge-admin">
                            ★ Administrator
                        </span>
                    </div>
                </div>
            </div>
            
            <button type="button" class="btn-edit" onclick="window.location.href='{{ route('admin.profile.edit') }}'">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Profile
            </button>
        </div>
    </div>
    
    <!-- Profile Body -->
    <div class="profile-body">
        <!-- Informasi Personal -->
        <div class="info-section">
            <div class="section-title">
                <svg class="title-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Personal
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $user->name }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $user->email }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Username</div>
                    <div class="info-value">{{ $user->name }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Role</div>
                    <div class="info-value">
                        <span class="badge badge-admin">Administrator</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tombol Kembali di Kanan -->
        <div class="footer-actions">
            <a href="{{ route('dashboard.admin') }}" class="btn-back">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
</div>
@endsection