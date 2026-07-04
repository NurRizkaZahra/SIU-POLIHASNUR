{{-- Overlay backdrop untuk mobile (klik di luar = tutup sidebar) --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="sidebar" id="mainSidebar">
    <div class="logo">
        <span>SIU-POLIHASNUR</span>
    </div>

    <div class="profile">
        <a href="{{ route('camaba.profile') }}" class="profile" style="text-decoration:none; color:inherit;">
            <div class="profile-icon">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}"
                    alt="Profile" class="sidebar-avatar">
            </div>

            <div class="badge">{{ auth()->user()->role ?? 'camaba' }}</div>
            <div class="profile-name">{{ auth()->user()->name ?? 'Guest User' }}</div>
        </a>
    </div>

    <ul class="menu">
        @role('camaba')
            <li class="menu-item">
                <a href="{{ route('camaba.dashboard') }}"
                    class="menu-link {{ request()->routeIs('camaba.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">🏠</span>
                    <span>BERANDA</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('camaba.registration') }}"
                    class="menu-link {{ request()->routeIs('camaba.registration') ? 'active' : '' }}">
                    <span class="menu-icon">📋</span>
                    <span>PENDAFTARAN</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('camaba.exam-schedule') }}"
                    class="menu-link {{ request()->routeIs('camaba.exam-schedule') ? 'active' : '' }}">
                    <span class="menu-icon">📅</span>
                    <span>JADWAL UJIAN</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('camaba.exam.index') }}"
                    class="menu-link {{ request()->routeIs('camaba.exam.index') ? 'active' : '' }}">
                    <span class="menu-icon">📝</span>
                    <span>UJIAN</span>
                </a>
            </li>
        @endrole
    </ul>
</div>
