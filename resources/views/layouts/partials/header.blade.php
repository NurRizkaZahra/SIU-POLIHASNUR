<div class="header">
    <div class="header-left">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <h1 class="header-title">@yield('page-title', 'DASHBOARD')</h1>
    </div>

    <div class="header-actions">
        @php
            $unreadNotif = auth()->check()
                ? \App\Models\Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count()
                : 0;
        @endphp

        <a href="{{ route('camaba.notifications') }}" class="icon-btn" title="Notifikasi" style="position: relative;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5S10.5 3.17 10.5 4v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
            </svg>

            @if($unreadNotif > 0)
                <span style="
                    position: absolute;
                    top: -5px;
                    right: -5px;
                    background: #ef4444;
                    color: white;
                    font-size: 11px;
                    font-weight: bold;
                    padding: 2px 6px;
                    border-radius: 50%;
                ">
                    {{ $unreadNotif }}
                </span>
            @endif
        </a>

        <!-- Profile Dropdown -->
        <div class="profile-dropdown">
            <button class="icon-btn" onclick="toggleProfileDropdown()" title="Profil">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                </svg>
            </button>

            <div class="dropdown-menu" id="profileDropdown">
                <div class="dropdown-header">
                    <div class="user-info">
                        <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
                        <small>{{ auth()->user()->email ?? 'guest@example.com' }}</small>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                    </svg>
                    Profile
                </a>

                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>