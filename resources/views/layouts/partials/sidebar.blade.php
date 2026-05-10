{{-- Overlay backdrop untuk mobile (klik di luar = tutup sidebar) --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="sidebar" id="mainSidebar">
    <div class="logo">
        <span>SIU-POLIHASNUR</span>
    </div>

    <div class="profile">
        <div class="profile-icon">
            <svg viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        </div>
        <div class="badge">{{ auth()->user()->role ?? 'camaba' }}</div>
        <div class="profile-name">{{ auth()->user()->name ?? 'Guest User' }}</div>
    </div>

    <ul class="menu">
        @role('camaba')
        <li class="menu-item">
            <a href="{{ route('camaba.dashboard') }}" class="menu-link {{ request()->routeIs('camaba.dashboard') ? 'active' : '' }}">
                <span class="menu-icon">🏠</span>
                <span>BERANDA</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('camaba.registration') }}" class="menu-link {{ request()->routeIs('camaba.registration') ? 'active' : '' }}">
                <span class="menu-icon">📋</span>
                <span>PENDAFTARAN</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('camaba.exam-schedule') }}" class="menu-link {{ request()->routeIs('camaba.exam-schedule') ? 'active' : '' }}">
                <span class="menu-icon">📅</span>
                <span>JADWAL UJIAN</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('camaba.exam.index') }}" class="menu-link {{ request()->routeIs('camaba.exam.index') ? 'active' : '' }}">
                <span class="menu-icon">📝</span>
                <span>UJIAN</span>
            </a>
        </li>
        @endrole
    </ul>
</div>

{{--
    CATATAN: Semua JavaScript untuk sidebar (toggleSidebar, closeSidebar, dll.)
    sudah dipindah ke partials/scripts.blade.php agar tidak duplikasi.
    Pastikan @include('partials.scripts') ada di layout utama (biasanya sebelum </body>).
--}}