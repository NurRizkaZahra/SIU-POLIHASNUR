<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIU-POLIHASNUR - Beranda</title>
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

        /* Sidebar */
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

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .header {
            background: linear-gradient(90deg, #1e5a96 0%, #0d3d6b 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-toggle {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            display: flex;
            flex-direction: column;
            gap: 4px;
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
        }

        .header-actions {
            display: flex;
            gap: 20px;
            align-items: center;
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

        .content {
            flex: 1;
            padding: 0;
            overflow-y: auto;
        }

        /* ======================== */
        /*     HERO SECTION FIX     */
        /* ======================== */
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

        /* ======================== */
        /*  BAGIAN PENDAFTARAN DST */
        /* ======================== */
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
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
                <div class="badge">camaba</div>
                <div class="profile-name">Nur Rizka Zahra</div>
            </div>

            <ul class="menu">
                <li class="menu-item">
                    <a href="#" class="menu-link active">
                        <span class="menu-icon">🏠</span>
                        <span>BERANDA</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('pendaftaran') }}" class="menu-link">
                        <span class="menu-icon">📋</span>
                        <span>PENDAFTARAN</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('jadwal.ujian') }}" class="menu-link">
                        <span class="menu-icon">📅</span>
                        <span>JADWAL UJIAN</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">📝</span>
                        <span>UJIAN</span>
                    </a>
        
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="header-left">
                    <button class="menu-toggle" onclick="toggleSidebar()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <h1 class="header-title">BERANDA</h1>
                </div>
                <div class="header-actions">
                    <button class="icon-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/>
                        </svg>
                    </button>
                    <button class="icon-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                        </svg>
                    </button>
                    <button class="icon-btn close-btn">×</button>
                </div>
            </div>

            <div class="content">
                <div class="hero-section">
                    <div class="hero-overlay"></div>
                    <div class="hero-content">
                        <h1 class="hero-title">Selamat Datang di<br>SIU (Sistem Informasi Ujian)<br>Politeknik Hasnur</h1>
                        <p class="hero-subtitle">
                            Sistem ini dirancang untuk mendukung proses evaluasi akademik di Politeknik Hasnur secara efisien, transparan, dan modern. Melalui platform ini, mahasiswa dapat mengikuti ujian secara online, aman, dan mudah diakses kapan saja.
                        </p>
                        <div class="hero-buttons">
                            <a href="#" class="btn-primary">Pilih Jadwal</a>
                            <a href="{{ route('pendaftaran') }}" class="btn-secondary">Lengkapi Data Diri</a>
                        </div>
                    </div>
                </div>

                <div class="section-content">
                    <div class="registration-title">ALUR PENDAFTARAN</div>

                    <div class="step-list">
                        <div class="step-item" onclick="toggleStep(this)">
                            <div class="step-header">
                                <span class="step-text">1. Melengkapi Data Diri</span>
                                <div class="chevron-icon">∨</div>
                            </div>
                            <div class="step-content">
                                <div class="step-detail">
                                    Lengkapi data diri Anda meliputi:<br>
                                    • Identitas pribadi (Nama, NIK, Tempat/Tanggal Lahir)<br>
                                    • Alamat lengkap<br>
                                    • Informasi orang tua/wali<br>
                                    • Riwayat pendidikan<br>
                                    • Upload dokumen yang diperlukan
                                </div>
                            </div>
                        </div>

                        <div class="step-item" onclick="toggleStep(this)">
                            <div class="step-header">
                                <span class="step-text">2. Mengikuti Ujian Masuk</span>
                                <div class="chevron-icon">∨</div>
                            </div>
                            <div class="step-content">
                                <div class="step-detail">
                                    Ikuti tahapan ujian masuk:<br>
                                    • Cek jadwal ujian pada menu Jadwal Ujian<br>
                                    • Pastikan perangkat dan koneksi internet stabil<br>
                                    • Login 15 menit sebelum ujian dimulai<br>
                                    • Ikuti petunjuk ujian dengan teliti<br>
                                    • Tunggu pengumuman hasil ujian
                                </div>
                            </div>
                        </div>

                        <div class="step-item" onclick="toggleStep(this)">
                            <div class="step-header">
                                <span class="step-text">3. Daftar Ulang</span>
                                <div class="chevron-icon">∨</div>
                            </div>
                            <div class="step-content">
                                <div class="step-detail">
                                    Proses daftar ulang bagi yang diterima:<br>
                                    • Verifikasi pengumuman kelulusan<br>
                                    • Download formulir daftar ulang<br>
                                    • Lengkapi persyaratan administrasi<br>
                                    • Lakukan pembayaran biaya pendidikan<br>
                                    • Submit dokumen daftar ulang
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('expanded');
        }

        function toggleStep(element) {
            const content = element.querySelector('.step-content');
            const chevron = element.querySelector('.chevron-icon');
            
            content.classList.toggle('open');
            chevron.classList.toggle('open');
        }

        // Tutup sidebar saat klik di luar sidebar pada mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const menuToggle = document.querySelector('.menu-toggle');
            
            if (!sidebar.contains(event.target) && 
                !menuToggle.contains(event.target) && 
                window.innerWidth < 768 && 
                !sidebar.classList.contains('closed')) {
                toggleSidebar();
            }
        });
    </script>
</body>
</html>
