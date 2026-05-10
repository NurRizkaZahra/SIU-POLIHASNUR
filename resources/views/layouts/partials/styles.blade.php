<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
    }

    .container {
        display: flex;
        height: 100vh;
    }

    /* =====================
       SIDEBAR
    ===================== */
    .sidebar {
        width: 250px;
        background: linear-gradient(180deg, #1e5a96 0%, #0d3d6b 100%);
        color: white;
        padding: 20px;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        z-index: 1000;
        overflow-y: auto;
    }

    /* Desktop: sidebar bisa di-toggle dengan geser ke kiri */
    .sidebar.closed {
        transform: translateX(-250px);
    }

    /* Overlay backdrop untuk mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .sidebar-overlay.show {
        display: block;
    }

    .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        font-weight: 600;
        font-size: 16px;
    }

    .profile {
        text-align: center;
        margin-bottom: 40px;
    }

    .profile-icon {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 50%;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-icon svg {
        width: 50px;
        height: 50px;
        fill: #1e5a96;
    }

    .badge {
        background: #ffd700;
        color: #1e5a96;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 8px;
    }

    .profile-name {
        font-size: 14px;
        color: #cfe2f3;
    }

    .menu {
        list-style: none;
    }

    .menu-item {
        margin-bottom: 5px;
    }

    .menu-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s;
        font-size: 15px;
    }

    .menu-link:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .menu-link.active {
        background: rgba(255, 255, 255, 0.15);
    }

    .menu-icon {
        width: 20px;
        height: 20px;
    }

    /* =====================
       MAIN CONTENT
    ===================== */
    .main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        margin-left: 250px;
        transition: margin-left 0.3s ease;
        min-width: 0;
        /* Penting: mencegah konten meluap ke sidebar */
        overflow-x: hidden;
    }

    .main-content.expanded {
        margin-left: 0;
    }

    /* =====================
       HEADER
    ===================== */
    .header {
        background: linear-gradient(90deg, #1e5a96 0%, #0d3d6b 100%);
        color: white;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
        /* Memungkinkan title menyusut saat layar sempit */
        flex: 1;
    }

    .menu-toggle {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex-shrink: 0;
    }

    .menu-toggle span {
        width: 24px;
        height: 2px;
        background: white;
        transition: transform 0.3s ease;
    }

    .header-title {
        font-size: 22px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .header-actions {
        display: flex;
        gap: 20px;
        align-items: center;
        flex-shrink: 0;
    }

    .icon-btn {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* =====================
       CONTENT
    ===================== */
    .content {
        flex: 1;
        padding: 0;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* =====================
       HERO SECTION
    ===================== */
    .hero-section {
        position: relative;
        width: 100%;
        height: 500px;
        background: url('{{ asset('images/proyek 3.png') }}') no-repeat center center/cover;
        display: flex;
        align-items: center;
        padding: 0 60px;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(135, 206, 235, 0.85) 0%, rgba(135, 206, 235, 0.6) 50%, rgba(135, 206, 235, 0.3) 100%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 600px;
        color: #1a1a1a;
    }

    .hero-title {
        font-size: 32px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 20px;
        color: #1e5a96;
    }

    .hero-subtitle {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 30px;
        color: #2c2c2c;
    }

    .hero-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: #1e5a96;
        color: white;
        padding: 12px 28px;
        border-radius: 25px;
        border: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary:hover {
        background: #0d3d6b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 90, 150, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #1e5a96;
        padding: 12px 28px;
        border-radius: 25px;
        border: 2px solid #1e5a96;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary:hover {
        background: #1e5a96;
        color: white;
        transform: translateY(-2px);
    }

    .badge-kampus {
        position: absolute;
        top: 40px;
        right: 60px;
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #1e5a96;
        padding: 20px 30px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 18px;
        text-align: center;
        line-height: 1.4;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transform: rotate(3deg);
        z-index: 3;
    }

    .badge-kampus::before {
        content: '🎓';
        position: absolute;
        font-size: 30px;
        top: -15px;
        right: -10px;
    }

    .badge-kampus::after {
        content: '✨';
        position: absolute;
        font-size: 20px;
        bottom: -10px;
        left: -10px;
    }

    /* =====================
       SECTION CONTENT
    ===================== */
    .section-content {
        padding: 40px 30px;
    }

    .registration-title {
        text-align: center;
        color: #1e5a96;
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 20px;
    }

    .step-list {
        max-width: 700px;
        margin: 0 auto;
    }

    .step-item {
        background: white;
        border: 2px solid #1e5a96;
        border-radius: 8px;
        padding: 18px 20px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .step-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .step-item:hover {
        background: #f0f7ff;
    }

    .step-text {
        color: #1e5a96;
        font-weight: 500;
        font-size: 15px;
    }

    .chevron-icon {
        width: 24px;
        height: 24px;
        background: #1e5a96;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
        transition: transform 0.3s ease;
        flex-shrink: 0;
    }

    .chevron-icon.open {
        transform: rotate(180deg);
    }

    .step-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        padding: 0 0;
    }

    .step-content.open {
        max-height: 500px;
        padding: 15px 0 0 0;
    }

    .step-detail {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        padding-left: 10px;
        border-left: 3px solid #1e5a96;
    }

    /* =====================
       DROPDOWN (dari header.blade.php)
    ===================== */
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
        z-index: 999;
        overflow: hidden;
    }

    .dropdown-menu.show {
        display: block;
        animation: fadeIn 0.25s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .dropdown-header {
        background: #1e40af;
        color: white;
        padding: 12px;
    }

    .user-info strong {
        display: block;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .user-info small {
        display: block;
        font-size: 13px;
        opacity: 0.8;
    }

    .dropdown-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        text-decoration: none;
        color: #111827;
        transition: background 0.2s;
        width: 100%;
        border: none;
        background: none;
        cursor: pointer;
        text-align: left;
        font-size: 14px;
    }

    .dropdown-item:hover { background: #f3f4f6; }

    .logout-btn { color: #dc2626; }
    .logout-btn:hover { background: #fee2e2; }

    /* =====================
       RESPONSIVE — TABLET (≤ 1024px)
    ===================== */
    @media (max-width: 1024px) {
        .hero-section {
            height: 420px;
            padding: 0 40px;
        }

        .badge-kampus {
            right: 30px;
            font-size: 15px;
            padding: 15px 20px;
        }

        .hero-title {
            font-size: 26px;
        }

        .section-content {
            padding: 30px 20px;
        }
    }

    /* =====================
       RESPONSIVE — MOBILE (≤ 768px)
    ===================== */
    @media (max-width: 768px) {
        /* Sidebar tersembunyi secara default di mobile */
        .sidebar {
            transform: translateX(-250px);
        }

        /* Muncul saat class .open ditambahkan */
        .sidebar.open {
            transform: translateX(0);
        }

        /* Main content full-width di mobile — !important
           agar tidak tertimpa oleh JS saat resize */
        .main-content {
            margin-left: 0 !important;
        }

        /* Header */
        .header {
            padding: 12px 16px;
        }

        .header-title {
            font-size: 16px;
        }

        .header-actions {
            gap: 12px;
        }

        /* Dropdown lebih sempit di mobile */
        .dropdown-menu {
            min-width: 200px;
            right: -10px;
        }

        .user-info strong { font-size: 14px; }
        .user-info small  { font-size: 12px; }

        /* Hero */
        .hero-section {
            height: auto;
            min-height: 300px;
            padding: 30px 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .hero-overlay {
            background: linear-gradient(to bottom, rgba(135, 206, 235, 0.9) 0%, rgba(135, 206, 235, 0.7) 100%);
        }

        .hero-content {
            max-width: 100%;
        }

        .hero-title {
            font-size: 20px;
            margin-bottom: 12px;
        }

        .hero-subtitle {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .hero-buttons {
            gap: 10px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 10px 20px;
            font-size: 13px;
        }

        /* Badge kampus turun ke bawah konten di mobile */
        .badge-kampus {
            position: relative;
            top: auto;
            right: auto;
            transform: none;
            display: inline-block;
            margin-top: 20px;
            font-size: 14px;
            padding: 12px 18px;
        }

        /* Section */
        .section-content {
            padding: 20px 15px;
        }

        .step-item {
            padding: 14px 15px;
        }

        .step-text {
            font-size: 14px;
        }
    }

    /* =====================
       RESPONSIVE — SMALL MOBILE (≤ 480px)
    ===================== */
    @media (max-width: 480px) {
        .header-title {
            font-size: 14px;
        }

        .hero-title {
            font-size: 18px;
        }

        .hero-subtitle {
            font-size: 13px;
        }

        .hero-buttons {
            flex-direction: column;
            gap: 8px;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            text-align: center;
        }

        .profile-icon {
            width: 64px;
            height: 64px;
        }

        .profile-icon svg {
            width: 40px;
            height: 40px;
        }

        .section-content {
            padding: 16px 12px;
        }
    }
</style>