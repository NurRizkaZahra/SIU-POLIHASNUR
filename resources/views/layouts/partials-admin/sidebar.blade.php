{{-- Overlay gelap untuk mobile saat sidebar terbuka --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="sidebar" id="adminSidebar">
    <div class="logo">
        <span>SIU-POLIHASNUR</span>
    </div>

    <div class="profile">
        <a href="{{ route('admin.profile') }}" class="profile" style="text-decoration:none; color:inherit;">
            <div class="profile-icon">
    <img
        src="{{ auth()->user()->photo
            ? asset('storage/' . auth()->user()->photo)
            : asset('images/default-avatar.png') }}"
        alt="Profile"
        class="sidebar-avatar">
</div>
            <div class="badge">{{ auth()->user()->role ?? 'Admin' }}</div>
            <div class="profile-name">{{ auth()->user()->name ?? 'Nur Rizka Zahra' }}</div>
        </a>
    </div>

    <ul class="menu">

        {{-- BERANDA --}}
        <li class="menu-item">
            <a href="{{ route('dashboard.admin') }}"
               class="menu-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}"
               onclick="closeSidebarOnMobile()">
                <span class="menu-icon">🏠</span>
                <span>BERANDA</span>
            </a>
        </li>

        {{-- PENDAFTARAN --}}
        <li class="menu-item">
            <a href="{{ route('admin.registration') }}"
               class="menu-link {{ request()->routeIs('admin.registration') ? 'active' : '' }}"
               onclick="closeSidebarOnMobile()">
                <span class="menu-icon">📋</span>
                <span>PENDAFTARAN</span>
            </a>
        </li>

        {{-- JADWAL UJIAN --}}
        <li class="menu-item">
            <a href="{{ route('admin.exam-schedule-admin') }}"
               class="menu-link {{ request()->routeIs('admin.exam-schedule-admin') ? 'active' : '' }}"
               onclick="closeSidebarOnMobile()">
                <span class="menu-icon">📅</span>
                <span>JADWAL UJIAN</span>
            </a>
        </li>

        {{-- UJIAN --}}
        <li class="menu-item">
            <a href="{{ route('admin.questions.index') }}"
               class="menu-link {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}"
               onclick="closeSidebarOnMobile()">
                <span class="menu-icon">🧾</span>
                <span>UJIAN</span>
            </a>
        </li>

        {{-- HASIL --}}
        <li class="menu-item">
            <a href="{{ route('admin.results') }}"
               class="menu-link {{ request()->routeIs('admin.results') ? 'active' : '' }}"
               onclick="closeSidebarOnMobile()">
                <span class="menu-icon">📝</span>
                <span>HASIL</span>
            </a>
        </li>

    </ul>
</div>

<style>
    /* ── Overlay (hanya mobile) ── */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 999;
    }

    .sidebar-overlay.show { display: block; }

    .profile-icon{
    width:90px;
    height:90px;
    border-radius:50%;
    overflow:hidden;
    margin:0 auto;
    border:4px solid #fff;
    display:flex;
    align-items:center;
    justify-content:center;
}

.sidebar-avatar{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:50%;
    display:block;
}

    /* ========================
       RESPONSIVE — sidebar
    ======================== */
    @media (max-width: 768px) {
        /* Sidebar tersembunyi di kiri, muncul saat toggle */
        .sidebar {
            transform: translateX(-250px);
            z-index: 1000;
            /* pastikan shadow menonjol saat slide-in */
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
        }

        /* Saat sidebar terbuka di mobile: hapus class 'closed' → tampil */
        .sidebar:not(.closed) {
            transform: translateX(0);
        }

        /* main-content tidak perlu margin di mobile */
        .main-content {
            margin-left: 0 !important;
        }

        /* Profile name tidak overflow */
        .profile-name {
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
            margin: 0 auto;
        }
    }

    /* Tablet (768–1024) — sidebar lebih sempit */
    @media (min-width: 769px) and (max-width: 1024px) {
        .sidebar { width: 210px; }
        .main-content { margin-left: 210px; }

        .menu-link {
            font-size: 13px;
            padding: 10px 12px;
        }

        .profile-icon {
            width: 64px;
            height: 64px;
        }

        .profile-icon{
    width:80px;
    height:80px;
    margin:0 auto 12px;
    overflow:hidden;
    border-radius:50%;
    border:3px solid rgba(255,255,255,.2);
}

.sidebar-avatar{
    width:100%;
    height:100%;
    object-fit:cover;
}
    }
</style>