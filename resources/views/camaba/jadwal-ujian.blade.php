<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIU-POLIHASNUR - Jadwal Ujian</title>
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
            font-size: 18px;
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
            padding: 40px 30px;
            overflow-y: auto;
        }

        /* Jadwal Ujian Styles */
        .jadwal-title {
            text-align: center;
            color: #1e5a96;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .gelombang-container {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .gelombang-item {
            background: white;
            border: 2px solid #87ceeb;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s;
        }

        .gelombang-item:hover {
            box-shadow: 0 4px 12px rgba(30, 90, 150, 0.15);
        }

        .gelombang-title {
            color: #1e5a96;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .gelombang-input-group {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .input-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            background: white;
            border: 2px solid #87ceeb;
            border-radius: 20px;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .input-wrapper:focus-within {
            border-color: #1e5a96;
            box-shadow: 0 0 8px rgba(30, 90, 150, 0.2);
        }

        .input-wrapper input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 14px;
            background: transparent;
            color: #333;
        }

        .input-wrapper input::-webkit-calendar-picker-indicator {
            cursor: pointer;
        }

        .input-icon {
            width: 18px;
            height: 18px;
            color: #1e5a96;
            margin-right: 8px;
        }

        .btn-ajukan {
            background: #ffd700;
            color: #1e5a96;
            padding: 10px 28px;
            border-radius: 20px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .btn-ajukan:hover {
            background: #ffed4e;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        }

        .btn-ajukan:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
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
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <span class="menu-icon">🏠</span>
                        <span>BERANDA</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('pendaftaran') }}" class="menu-link active">
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
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">🚪</span>
                        <span>LOGOUT</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <div class="header">
                <div class="header-left">
                    <button class="menu-toggle" onclick="toggleSidebar()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <h1 class="header-title">JADWAL UJIAN</h1>
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
                <h2 class="jadwal-title">Jadwal Ujian Anda</h2>
                
                <div class="gelombang-container">
                    <!-- Gelombang 1 -->
                    <div class="gelombang-item">
                        <div class="gelombang-title">Gelombang 1 (21-25 Juli 2025)</div>
                        <div class="gelombang-input-group">
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                                <input type="date" placeholder="Pilih Tanggal">
                            </div>
                            <button class="btn-ajukan">Ajukan</button>
                        </div>
                    </div>

                    <!-- Gelombang 2 -->
                    <div class="gelombang-item">
                        <div class="gelombang-title">Gelombang 2 (1-15 Agustus 2025)</div>
                        <div class="gelombang-input-group">
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                                <input type="date" placeholder="Pilih Tanggal">
                            </div>
                            <button class="btn-ajukan">Ajukan</button>
                        </div>
                    </div>

                    <!-- Gelombang 3 -->
                    <div class="gelombang-item">
                        <div class="gelombang-title">Gelombang 3 (20-31 Agustus 2025)</div>
                        <div class="gelombang-input-group">
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                                <input type="date" placeholder="Pilih Tanggal">
                            </div>
                            <button class="btn-ajukan">Ajukan</button>
                        </div>
                    </div>

                    <!-- Gelombang 4 -->
                    <div class="gelombang-item">
                        <div class="gelombang-title">Gelombang 4 (1-15 September 2025)</div>
                        <div class="gelombang-input-group">
                            <div class="input-wrapper">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                                <input type="date" placeholder="Pilih Tanggal">
                            </div>
                            <button class="btn-ajukan">Ajukan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('expanded');
        }

        // Event listener untuk tombol Ajukan
        document.querySelectorAll('.btn-ajukan').forEach(btn => {
            btn.addEventListener('click', function() {
                const dateInput = this.previousElementSibling.querySelector('input[type="date"]');
                if (dateInput.value) {
                    alert('Jadwal ujian untuk tanggal ' + dateInput.value + ' telah diajukan!');
                } else {
                    alert('Silahkan pilih tanggal terlebih dahulu');
                }
            });
        });
    </script>
</body>
</html>