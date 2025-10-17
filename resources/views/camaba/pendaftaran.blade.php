<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIU-POLIHASNUR - Form Pendaftaran</title>
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
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        }

        /* Form Pendaftaran */
        .pendaftaran-container {
            max-width: 1000px;
            margin: 15px auto;
            padding: 20px;
        }

        .form-title {
            text-align: center;
            color: #1e5a96;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .form-section {
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid #1e5a96;
        }

        .section-header {
            background: #1e5a96;
            color: white;
            padding: 18px 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            font-size: 16px;
            transition: background 0.3s;
            user-select: none;
        }

        .section-header:hover {
            background: #0d3d6b;
        }

        .chevron-icon {
            width: 28px;
            height: 28px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e5a96;
            font-weight: bold;
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .chevron-icon.open {
            transform: rotate(180deg);
        }

        .section-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            background: #f8f9fa;
        }

        .section-body.open {
            max-height: 2500px;
            padding: 30px 25px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #1e5a96;
            box-shadow: 0 0 0 3px rgba(30, 90, 150, 0.1);
        }

        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .radio-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: normal;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .radio-group label:hover {
            background: #e3f2fd;
        }

        .radio-group input[type="radio"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #1e5a96;
        }

        .save-btn {
            background: #1e5a96;
            color: white;
            padding: 12px 35px;
            margin-top: 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            float: right;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(30, 90, 150, 0.2);
        }

        .save-btn:hover {
            background: #0d3d6b;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(30, 90, 150, 0.3);
        }

        .next-btn {
            background: #DBD328;
            color: #0d3d6b;
            padding: 15px 50px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 18px;
            display: block;
            margin: 30px auto 0;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(101, 100, 24, 0.2);
        }

        .next-btn:hover {
            background: #DBD328;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(101, 100, 24, 0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.closed {
                transform: translateX(-250px);
            }

            .sidebar:not(.closed) {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .pendaftaran-container {
                padding: 15px;
            }

            .form-title {
                font-size: 24px;
            }
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
                    <h1 class="header-title">FORM PENDAFTARAN</h1>
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
                <div class="pendaftaran-container">
                
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('pendaftaran.simpan') }}" method="POST">
                        @csrf

                        <!-- DATA DIRI -->
                        <div class="form-section">
                            <div class="section-header" onclick="toggleFormSection(this)">
                                <span>DATA DIRI</span>
                                <div class="chevron-icon open">∨</div>
                            </div>
                            <div class="section-body open">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Lengkap: <span style="color: red;">*</span></label>
                                        <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Lengkap: <span style="color: red;">*</span></label>
                                        <input type="text" name="alamat_lengkap" placeholder="Masukkan alamat" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tempat Lahir: <span style="color: red;">*</span></label>
                                        <input type="text" name="tempat_lahir" placeholder="Kota lahir" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Telepon/Hp: <span style="color: red;">*</span></label>
                                        <input type="text" name="telepon/hp" placeholder="telepon/hp" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Jenis Kelamin: <span style="color: red;">*</span></label>
                                    <div class="radio-group">
                                        <label><input type="radio" name="jenis_kelamin" value="Laki-laki" required> Laki-laki</label>
                                        <label><input type="radio" name="jenis_kelamin" value="Perempuan" required> Perempuan</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Agama: <span style="color: red;">*</span></label>
                                    <div class="radio-group">
                                        <label><input type="radio" name="agama" value="Islam" required> Islam</label>
                                        <label><input type="radio" name="agama" value="Kristen" required> Kristen</label>
                                        <label><input type="radio" name="agama" value="Katolik" required> Katolik</label>
                                        <label><input type="radio" name="agama" value="Hindu" required> Hindu</label>
                                        <label><input type="radio" name="agama" value="Budha" required> Budha</label>
                                        <label><input type="radio" name="agama" value="Lainnya" required> Lainnya</label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>No. Kartu Keluarga: <span style="color: red;">*</span></label>
                                        <input type="text" name="no_kk" placeholder="Nomor KK" required>
                                    </div>
                                    <div class="form-group">
                                        <label>NIK: <span style="color: red;">*</span></label>
                                        <input type="text" name="nik" placeholder="Nomor NIK" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Lahir: <span style="color: red;">*</span></label>
                                    <input type="date" name="tanggal_lahir" required>
                                </div>

                                <button type="button" class="save-btn" onclick="saveSection('Data Diri')">Save</button>
                                <div style="clear: both;"></div>
                            </div>
                        </div>

                        <!-- PENDIDIKAN -->
                        <div class="form-section">
                            <div class="section-header" onclick="toggleFormSection(this)">
                                <span>PENDIDIKAN</span>
                                <div class="chevron-icon open">∨</div>
                            </div>
                            <div class="section-body open">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Sekolah Asal: <span style="color: red;">*</span></label>
                                        <input type="text" name="sekolah_asal" placeholder="Nama sekolah" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor Pokok Sekolah Nasional (NPSN): <span style="color: red;">*</span></label>
                                        <input type="text" name="npsn" placeholder="NPSN" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Alamat Sekolah: <span style="color: red;">*</span></label>
                                        <input type="text" name="alamat_sekolah" placeholder="Masukkan Alamat Lengkap" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jurusan/Program Keahlian: <span style="color: red;">*</span></label>
                                        <input type="text" name="program_keahlian" placeholder="Program keahlian" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Tahun Masuk: <span style="color: red;">*</span></label>
                                        <input type="text" name="tahun_masuk" placeholder="Tahun" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Prestasi Akademik dan Nilai Akademik:</label>
                                        <input type="text" name="prestasi_akademik" placeholder="Prestasi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Nomor Induk Siswa Nasional (NISN): <span style="color: red;">*</span></label>
                                    <input type="text" name="nisn" placeholder="NISN" required>
                                </div>

                                <button type="button" class="save-btn" onclick="saveSection('Pendidikan')">Save</button>
                                <div style="clear: both;"></div>
                            </div>
                        </div>

                        <!-- KELUARGA -->
                        <div class="form-section">
                            <div class="section-header" onclick="toggleFormSection(this)">
                                <span>KELUARGA</span>
                                <div class="chevron-icon open">∨</div>
                            </div>
                            <div class="section-body open">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Ayah/Wali: <span style="color: red;">*</span></label>
                                        <input type="text" name="nama_ayah" placeholder="Nama ayah" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah Anak: <span style="color: red;">*</span></label>
                                        <input type="number" name="jumlah_anak" placeholder="Jumlah" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Pekerjaan Ayah: <span style="color: red;">*</span></label>
                                        <input type="text" name="pekerjaan_ayah" placeholder="Pekerjaan" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Anak Ke: <span style="color: red;">*</span></label>
                                        <input type="number" name="anak_ke" placeholder="Urutan" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Ibu/Wali: <span style="color: red;">*</span></label>
                                        <input type="text" name="nama_ibu" placeholder="Nama ibu" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Penghasilan Ayah dan Ibu: <span style="color: red;">*</span></label>
                                        <select name="penghasilan_ortu" required>
                                            <option value="">Pilih range</option>
                                            <option value="< Rp 1.000.000">< Rp 1.000.000</option>
                                            <option value="Rp 1.000.000 - Rp 2.499.000">Rp 1.000.000 - Rp 2.499.000</option>
                                            <option value="Rp 2.500.000 - Rp 4.999.000">Rp 2.500.000 - Rp 4.999.000</option>
                                            <option value="> Rp 5.000.000">> Rp 5.000.000</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Pekerjaan Ibu: <span style="color: red;">*</span></label>
                                        <input type="text" name="pekerjaan_ibu" placeholder="Pekerjaan" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat: <span style="color: red;">*</span></label>
                                        <input type="text" name="alamat_ortu" placeholder="Alamat lengkap" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Nomor HP: <span style="color: red;">*</span></label>
                                    <input type="tel" name="no_hp" placeholder="Nomor HP" required>
                                </div>

                                <button type="button" class="save-btn" onclick="saveSection('Keluarga')">Save</button>
                                <div style="clear: both;"></div>
                            </div>
                        </div>

                        <button type="submit" class="next-btn">Next →</button>
                    </form>
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

        function toggleFormSection(header) {
            const body = header.nextElementSibling;
            const chevron = header.querySelector('.chevron-icon');
            
            body.classList.toggle('open');
            chevron.classList.toggle('open');
        }

        function saveSection(sectionName) {
            // Show confirmation
            alert('Data ' + sectionName + ' berhasil disimpan!');
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

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>