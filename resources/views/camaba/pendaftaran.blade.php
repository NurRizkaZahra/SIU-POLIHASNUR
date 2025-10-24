@extends('layouts.app')

@section('title', 'Form Pendaftaran')

@section('page-title', 'PENDAFTARAN') 

@section('content')
<style>
    /* Form Pendaftaran Styles */
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

    .next-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 15px;
    margin-bottom: 70px;
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
         text-decoration: none;
        box-shadow: 0 4px 8px rgba(101, 100, 24, 0.2);
    }

    .next-btn:hover {
        background: #c9c224;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(101, 100, 24, 0.3);
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

    /* Responsive */
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .pendaftaran-container {
            padding: 15px;
        }

        .form-title {
            font-size: 24px;
        }
    }
</style>

<div class="pendaftaran-container">
    {{-- ALERT SUCCESS / ERROR --}}
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

    {{-- FORM DATA DIRI --}}
    <form action="{{ route('camaba.data-diri.simpan') }}" method="POST">
        @csrf

        <div class="form-section">
            <div class="section-header" onclick="toggleFormSection(this)">
                <span>DATA DIRI</span>
                <div class="chevron-icon open">∨</div>
            </div>

            <div class="section-body open">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap: <span style="color: red;">*</span></label>
                        <input type="text" name="full_name" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap: <span style="color: red;">*</span></label>
                        <input type="text" name="address" placeholder="Masukkan alamat" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tempat Lahir: <span style="color: red;">*</span></label>
                        <input type="text" name="place_of_birth" placeholder="Kota lahir" required>
                    </div>
                    <div class="form-group">
                        <label>Telepon/HP: <span style="color: red;">*</span></label>
                        <input type="text" name="phone" placeholder="Telepon/HP" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin: <span style="color: red;">*</span></label>
                    <div class="radio-group">
                        <label><input type="radio" name="gender" value="Laki-laki" required> Laki-laki</label>
                        <label><input type="radio" name="gender" value="Perempuan" required> Perempuan</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Agama: <span style="color: red;">*</span></label>
                    <div class="radio-group">
                        <label><input type="radio" name="religion" value="Islam" required> Islam</label>
                        <label><input type="radio" name="religion" value="Kristen" required> Kristen</label>
                        <label><input type="radio" name="religion" value="Katolik" required> Katolik</label>
                        <label><input type="radio" name="religion" value="Hindu" required> Hindu</label>
                        <label><input type="radio" name="religion" value="Budha" required> Budha</label>
                        <label><input type="radio" name="religion" value="Lainnya" required> Lainnya</label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>No. Kartu Keluarga: <span style="color: red;">*</span></label>
                        <input type="text" name="kk_number" placeholder="Nomor KK" required>
                    </div>
                    <div class="form-group">
                        <label>NIK: <span style="color: red;">*</span></label>
                        <input type="text" name="nik" placeholder="Nomor NIK" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir: <span style="color: red;">*</span></label>
                    <input type="date" name="date_of_birth" required>
                </div>

                <button type="submit" class="save-btn">Save</button>
            </div>
        </div>
    </form>
</div>

        <!-- PENDIDIKAN -->
        <form action="{{ route('camaba.data-pendidikan.simpan') }}" method="POST">
        @csrf
        <div class="pendaftaran-container">
        <div class="form-section">
            <div class="section-header" onclick="toggleFormSection(this)">
                <span>PENDIDIKAN</span>
                <div class="chevron-icon open">∨</div>
            </div>
            <div class="section-body open">
                <div class="form-row">
                    <div class="form-group">
                        <label>Sekolah Asal: <span style="color: red;">*</span></label>
                        <input type="text" name="school_name" placeholder="Nama sekolah" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Pokok Sekolah Nasional (NPSN): <span style="color: red;">*</span></label>
                        <input type="text" name="school_code" placeholder="NPSN" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Alamat Sekolah: <span style="color: red;">*</span></label>
                        <input type="text" name="school_address" placeholder="Masukkan Alamat Lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Jurusan/Program Keahlian: <span style="color: red;">*</span></label>
                        <input type="text" name="major" placeholder="Program keahlian" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tahun Masuk: <span style="color: red;">*</span></label>
                        <input type="text" name="year_of_entry" placeholder="Tahun" required>
                    </div>
                    <div class="form-group">
                        <label>Prestasi Akademik dan Nilai Akademik:</label>
                        <input type="text" name="achievement" placeholder="Prestasi">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nomor Induk Siswa Nasional (NISN): <span style="color: red;">*</span></label>
                    <input type="text" name="nisn" placeholder="NISN" required>
                </div>

                <button type="submit" class="save-btn">Save</button>
                </div>
            </div>
        </div>
    </form>

        <!-- KELUARGA -->
        <form action="{{ route('camaba.data-keluarga.simpan') }}" method="POST">
        @csrf
        <div class="pendaftaran-container">
        <div class="form-section">
            <div class="section-header" onclick="toggleFormSection(this)">
                <span>KELUARGA</span>
                <div class="chevron-icon open">∨</div>
            </div>
            <div class="section-body open">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Ayah/Wali: <span style="color: red;">*</span></label>
                        <input type="text" name="father_name" placeholder="Nama ayah" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Anak: <span style="color: red;">*</span></label>
                        <input type="number" name="number_of_children" placeholder="Jumlah" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Pekerjaan Ayah: <span style="color: red;">*</span></label>
                        <input type="text" name="father_job" placeholder="Pekerjaan" required>
                    </div>
                    <div class="form-group"> 
                        <label>Anak Ke: <span style="color: red;">*</span></label> 
                        <input type="number" name="child_order" placeholder="Urutan" required> 
                    </div> 
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Ibu/Wali: <span style="color: red;">*</span></label>
                        <input type="text" name="mother_name" placeholder="Nama ibu" required>
                    </div>
                    <div class="form-group">
                        <label>Penghasilan Ayah dan Ibu: <span style="color: red;">*</span></label>
                        <select name="parent_income" required>
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
                        <input type="text" name="mother_job" placeholder="Pekerjaan" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat: <span style="color: red;">*</span></label>
                        <input type="text" name="parent_address" placeholder="Alamat lengkap" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nomor HP: <span style="color: red;">*</span></label>
                    <input type="tel" name="parent_phone" placeholder="Nomor HP" required>
                </div>

               <button type="submit" class="save-btn">Save</button>
            </div>
        </div>
    </div>
</form>

<div class="next-wrapper">
  <a href="{{ route('pendaftaran-lanjutan') }}" class="next-btn">Next →</a>
</div>
      
<script>
    function toggleFormSection(header) {
        const body = header.nextElementSibling;
        const chevron = header.querySelector('.chevron-icon');
        
        body.classList.toggle('open');
        chevron.classList.toggle('open');
    }

    function saveSection(sectionName) {
        alert('Data ' + sectionName + ' berhasil disimpan!');
    }

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
@endsection