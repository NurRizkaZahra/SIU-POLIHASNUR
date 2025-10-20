<div class="sidebar">
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
        <div class="profile-name">{{ auth()->user()->name ?? 'Nur Rizka Zahra' }}</div>
    </div>

    <ul class="menu">
        <li class="menu-item">
            <a href="{{ route('dashboard.camaba') }}" class="menu-link {{ request()->routeIs('dashboard.camaba') ? 'active' : '' }}">
                <span class="menu-icon">🏠</span>
                <span>BERANDA</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('pendaftaran') }}" class="menu-link {{ request()->routeIs('pendaftaran*') ? 'active' : '' }}">
                <span class="menu-icon">📋</span>
                <span>PENDAFTARAN</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('jadwal.ujian') }}" class="menu-link {{ request()->routeIs('jadwal.ujian') ? 'active' : '' }}">
                <span class="menu-icon">📅</span>
                <span>JADWAL UJIAN</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link" style="opacity: 0.6; cursor: not-allowed;" title="Segera hadir">
                <span class="menu-icon">📝</span>
                <span>UJIAN</span>
            </a>
        </li>
    </ul>
</div>