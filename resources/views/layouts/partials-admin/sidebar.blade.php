<div class="sidebar">
    <div class="logo">
        <span>SIU-POLIHASNUR</span>
    </div>

    <div class="profile">
        <div class="profile-icon">
            <svg viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 
                1.79-4 4 1.79 4 4 4zm0 2c-2.67 
                0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        </div>
        <div class="badge">{{ auth()->user()->role ?? 'Admin' }}</div>
        <div class="profile-name">{{ auth()->user()->name ?? 'Nur Rizka Zahra' }}</div>
    </div>

    <ul class="menu">
        {{-- BERANDA --}}
        <li class="menu-item">
            <a href="{{ route('dashboard.admin') }}" 
               class="menu-link {{ request()->routeIs('admin.beranda') ? 'active' : '' }}">
                <span class="menu-icon">🏠</span>
                <span>BERANDA</span>
            </a>
        </li>

        {{-- PENDAFTARAN --}}
        <li class="menu-item">
            <a href="{{ route('admin.registration') }}" 
               class="menu-link {{ request()->routeIs('admin.pendaftaran') ? 'active' : '' }}">
                <span class="menu-icon">📋</span>
                <span>PENDAFTARAN</span>
            </a>
        </li>

        {{-- JADWAL UJIAN --}}
        <li class="menu-item">
            <a href="{{ route('admin.exam-schedule-admin') }}" 
               class="menu-link {{ request()->routeIs('admin.jadwal-ujian') ? 'active' : '' }}">
                <span class="menu-icon">📅</span>
                <span>JADWAL UJIAN</span>
            </a>
        </li>

        {{-- UJIAN --}}
        <li class="menu-item">
            <a href="#" 
               class="menu-link {{ request()->routeIs('admin.ujian') ? 'active' : '' }}">
                <span class="menu-icon">🧾</span>
                <span>UJIAN</span>
            </a>
        </li>

        {{-- HASIL --}}
        <li class="menu-item">
            <a href="#" class="menu-link" style="opacity: 0.6; cursor: not-allowed;" title="Segera hadir">
                <span class="menu-icon">📝</span>
                <span>HASIL</span>
            </a>
        </li>
    </ul>
</div>
