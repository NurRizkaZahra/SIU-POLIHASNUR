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

    /* ════════════════════════════
       SIDEBAR
    ════════════════════════════ */
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

    .sidebar.closed {
        transform: translateX(-250px);
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

    /* ════════════════════════════
       MAIN CONTENT
    ════════════════════════════ */
    .main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        margin-left: 250px;
        transition: margin-left 0.3s ease;
        min-width: 0;
        /* fix flex overflow */
    }

    .main-content.expanded {
        margin-left: 0;
    }

    /* ════════════════════════════
       HEADER
    ════════════════════════════ */
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
        display: block;
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

    .close-btn {
        font-size: 32px;
        font-weight: 300;
        line-height: 1;
    }

    /* ════════════════════════════
       CONTENT AREA
    ════════════════════════════ */
    .content {
        flex: 1;
        padding: 0;
        overflow-y: auto;
    }

    /* ════════════════════════════
       HERO SECTION
    ════════════════════════════ */
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
        background: linear-gradient(to right,
                rgba(135, 206, 235, 0.85) 0%,
                rgba(135, 206, 235, 0.6) 50%,
                rgba(135, 206, 235, 0.3) 100%);
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

    /* ════════════════════════════
       SECTION & STEPS
    ════════════════════════════ */
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
        padding: 0;
    }

    .step-content.open {
        max-height: 500px;
        padding: 15px 0 0;
    }

    .step-detail {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        padding-left: 10px;
        border-left: 3px solid #1e5a96;
    }

    /* ════════════════════════════
       RESPONSIVE
    ════════════════════════════ */

    /* Tablet (769–1024) */
    @media (min-width: 769px) and (max-width: 1024px) {
        .sidebar {
            width: 210px;
        }

        .main-content {
            margin-left: 210px;
        }

        .menu-link {
            font-size: 13px;
            padding: 10px 12px;
        }

        .profile-icon {
            width: 64px;
            height: 64px;
        }

        .profile-icon svg {
            width: 40px;
            height: 40px;
        }

        .header {
            padding: 15px 20px;
        }

        .header-title {
            font-size: 18px;
        }

        .hero-section {
            padding: 0 30px;
        }

        .hero-title {
            font-size: 26px;
        }

        .badge-kampus {
            right: 24px;
            top: 24px;
            font-size: 14px;
            padding: 14px 18px;
        }

        .section-content {
            padding: 30px 20px;
        }
    }

    /* Mobile (≤ 768px) */
    @media (max-width: 768px) {

        /* Sidebar: tersembunyi secara default, slide-in saat dibuka */
        .sidebar {
            transform: translateX(-250px);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
        }

        .sidebar:not(.closed) {
            transform: translateX(0);
        }

        /* Main content penuh tanpa margin */
        .main-content {
            margin-left: 0 !important;
        }

        .main-content.expanded {
            margin-left: 0 !important;
        }

        /* Header */
        .header {
            padding: 12px 16px;
            gap: 10px;
        }

        .header-title {
            font-size: 15px;
            max-width: 160px;
        }

        .header-actions {
            gap: 12px;
        }

        /* Hero */
        .hero-section {
            height: auto;
            min-height: 320px;
            padding: 32px 16px;
            flex-direction: column;
            align-items: flex-start;
        }

        .hero-title {
            font-size: 20px;
        }

        .hero-subtitle {
            font-size: 13.5px;
        }

        .badge-kampus {
            position: static;
            display: inline-block;
            transform: none;
            margin-top: 20px;
            font-size: 13px;
            padding: 12px 16px;
        }

        .badge-kampus::before,
        .badge-kampus::after {
            display: none;
        }

        /* Sections */
        .section-content {
            padding: 24px 14px;
        }

        .step-text {
            font-size: 13.5px;
        }

        .step-detail {
            font-size: 13px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 10px 20px;
            font-size: 13px;
        }

        .hero-buttons {
            gap: 10px;
        }
    }

    /* Small phones (≤ 480px) */
    @media (max-width: 480px) {
        .header-title {
            font-size: 13px;
            max-width: 120px;
        }

        .hero-section {
            min-height: 280px;
            padding: 24px 12px;
        }

        .hero-title {
            font-size: 17px;
        }

        .hero-subtitle {
            font-size: 12.5px;
        }

        .hero-buttons {
            flex-direction: column;
            gap: 8px;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            text-align: center;
            padding: 10px 16px;
        }

        .step-item {
            padding: 14px;
        }

        .step-text {
            font-size: 13px;
        }
    }
</style>
