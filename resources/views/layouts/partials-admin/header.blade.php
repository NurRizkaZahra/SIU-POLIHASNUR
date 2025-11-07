<div class="header">
    <div class="header-left">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <h1 class="header-title">@yield('page-title', 'DASHBOARD ADMIN')</h1>
    </div>
    <div class="header-actions">
        <!-- notifikasi -->
        @php
            $pendingCount = \App\Http\Controllers\Admin\AdminExamController::getPendingCount();
        @endphp
        
        <a href="{{ route('exam.notifications') }}" class="icon-btn-link">
            <button class="icon-btn" style="position: relative;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/>
                </svg>
                
                @if($pendingCount > 0)
                    <span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; font-weight: bold; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; animation: pulse 2s infinite;">
                        {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                    </span>
                @endif
            </button>
        </a>
        
        <!-- profil dropdown -->
        <div class="profile-dropdown">
            <button class="icon-btn" onclick="toggleProfileDropdown()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                </svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div class="dropdown-menu" id="profileDropdown">
                <div class="dropdown-header">
                    <div class="user-info">
                        <strong>{{ auth()->user()->name }}</strong>
                        <small>{{ auth()->user()->email }}</small>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-btn-link {
        text-decoration: none;
        display: inline-block;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }
    }

    /* Profile Dropdown Styles */
    .profile-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 10px;
        background: white;
        min-width: 250px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
        overflow: hidden;
    }

    .dropdown-menu.show {
        display: block;
        animation: dropdownFadeIn 0.2s ease;
    }

    @keyframes dropdownFadeIn {
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
        padding: 15px;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
    }

    .user-info strong {
        display: block;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .user-info small {
        display: block;
        opacity: 0.9;
        font-size: 13px;
    }

    .dropdown-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        color: #374151;
        text-decoration: none;
        transition: background 0.2s;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        font-size: 14px;
    }

    .dropdown-item:hover {
        background: #f3f4f6;
    }

    .dropdown-item svg {
        flex-shrink: 0;
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

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileDropdown');
        const profileBtn = document.querySelector('.profile-dropdown .icon-btn');
        
        if (!dropdown.contains(e.target) && !profileBtn.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });
</script>