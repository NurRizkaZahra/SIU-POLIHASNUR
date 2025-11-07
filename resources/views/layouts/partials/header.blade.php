<div class="header">
    <div class="header-left">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <h1 class="header-title">@yield('page-title', 'DASHBOARD')</h1>
    </div>

    <div class="header-right">
        <!-- Notifikasi -->
        <button class="icon-btn" title="Notifikasi">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                <path
                    d="M12 22c1.1 0 2-.9 2-2h-4c0
                    1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4
                    c0-.83-.67-1.5-1.5-1.5S10.5 3.17
                    10.5 4v.68C7.64 5.36 6 7.92 6
                    11v5l-2 2v1h16v-1l-2-2z" />
            </svg>
        </button>

        <!-- Profil Dropdown -->
        <div class="profile-dropdown">
            <button class="icon-btn" onclick="toggleProfileDropdown()" title="Profil">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                    <path
                        d="M12 2C6.48 2 2 6.48 2
                        12s4.48 10 10 10 10-4.48
                        10-10S17.52 2 12 2zm0
                        3c1.66 0 3 1.34 3
                        3s-1.34 3-3 3-3-1.34-3-3
                        1.34-3 3-3zm0 14.2c-2.5
                        0-4.71-1.28-6-3.22.03-1.99
                        4-3.08 6-3.08 1.99 0
                        5.97 1.09 6 3.08-1.29
                        1.94-3.5 3.22-6 3.22z" />
                </svg>
            </button>

            <!-- Dropdown -->
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
                        <path
                            d="M12 2C6.48 2 2 6.48 2
                            12s4.48 10 10 10 10-4.48
                            10-10S17.52 2 12 2zm0
                            3c1.66 0 3 1.34 3
                            3s-1.34 3-3 3-3-1.34-3-3
                            1.34-3 3-3zm0 14.2c-2.5
                            0-4.71-1.28-6-3.22.03-1.99
                            4-3.08 6-3.08 1.99 0
                            5.97 1.09 6 3.08-1.29
                            1.94-3.5 3.22-6 3.22z" />
                    </svg>
                    Profile
                </a>

                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17 7l-1.41 1.41L18.17
                                11H8v2h10.17l-2.58
                                2.58L17 17l5-5zM4
                                5h8V3H4c-1.1 0-2 .9-2
                                2v14c0 1.1.9 2 2
                                2h8v-2H4V5z" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(180deg, #1e5a96 );
    color: white;
    padding: 12px 25px; 
}

.menu-toggle {
    background: none;
    border: none;
    display: flex;
    flex-direction: column;
    gap: 4px;
    cursor: pointer;
}

.menu-toggle span {
    width: 22px;
    height: 2px;
    background: white;
    border-radius: 2px;
}

.header-title {
    font-size: 18px;
    margin-left: 15px;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.icon-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    border-radius: 50%;
    transition: background 0.2s;
}

.icon-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Profile Dropdown */
.profile-dropdown {
    position: relative;
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 110%;
    background: white;
    color: #111827;
    min-width: 240px;
    border-radius: 8px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    z-index: 999;
}

.dropdown-menu.show {
    display: block;
    animation: fadeIn 0.25s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-header {
    background: #1e40af;
    color: white;
    padding: 12px;
}

.user-info strong {
    font-size: 15px;
}

.user-info small {
    font-size: 13px;
    opacity: 0.8;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    text-decoration: none;
    color: #111827;
    transition: background 0.2s;
    border: none;
    background: none;
    width: 100%;
    cursor: pointer;
}

.dropdown-item:hover {
    background: #f3f4f6;
}

.logout-btn {
    color: #dc2626;
}

.logout-btn:hover {
    background: #fee2e2;
}
</style>

<script>
function toggleProfileDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('show');
}

window.addEventListener('click', function (e) {
    const dropdown = document.getElementById('profileDropdown');
    const profileBtn = document.querySelector('.profile-dropdown .icon-btn');
    if (!dropdown.contains(e.target) && !profileBtn.contains(e.target)) {
        dropdown.classList.remove('show');
    }
});
</script>
