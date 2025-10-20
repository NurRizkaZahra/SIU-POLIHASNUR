@extends('layouts.app')

@section('title', 'Form Pendaftaran Lanjutan')

@section('page-title', 'PENDAFTARAN LANJUTAN') 

@section('content')
<style>
    /* Form Pendaftaran Lanjutan Styles */
    .pendaftaran-container {
        max-width: 1000px;
        margin: 15px auto;
        padding: 20px;
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

    .radio-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
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

    .checkbox-group {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 8px;
    }

    .checkbox-group label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: normal;
        cursor: pointer;
        padding: 10px 15px;
        border-radius: 6px;
        transition: background 0.3s;
        font-size: 14px;
        min-height: 45px;
    }

    .checkbox-group label:hover {
        background: #e3f2fd;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #1e5a96;
    }

    .pilihan-section {
        margin-bottom: 30px;
    }

    .pilihan-title {
        font-weight: 600;
        color: #1e5a96;
        margin-bottom: 15px;
        font-size: 16px;
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

    .done-btn {
        background: white;
        color: #009347;
        border: 3px solid #009347;
        padding: 15px 50px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 18px;
        display: block;
        margin: 30px auto 0;
        transition: all 0.3s;
        box-shadow: 0 4px 8px rgba(30, 90, 150, 0.2);
    }

    .done-btn:hover {
        background: #009347;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(30, 90, 150, 0.3);
    }

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
        .radio-group {
            grid-template-columns: 1fr;
        }

        .checkbox-group {
            grid-template-columns: 1fr;
        }

        .pendaftaran-container {
            padding: 15px;
        }
    }
</style>

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

    <form action="{{ route('pendaftaran-lanjutan.store') }}" method="POST">
        @csrf

        <!-- JALUR MASUK -->
        <div class="form-section">
            <div class="section-header" onclick="toggleFormSection(this)">
                <span>JALUR MASUK</span>
                <div class="chevron-icon open">∨</div>
            </div>
            <div class="section-body open">
                <div class="form-group">
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="jalur_masuk" value="Mandiri" required>
                            Mandiri
                        </label>
                        <label>
                            <input type="radio" name="jalur_masuk" value="Beasiswa Unggulan" required>
                            Beasiswa Unggulan
                        </label>
                        <label>
                            <input type="radio" name="jalur_masuk" value="Berdikari" required>
                            Berdikari
                        </label>
                        <label>
                            <input type="radio" name="jalur_masuk" value="KIP-Kuliah" required>
                            KIP-Kuliah
                        </label>
                    </div>
                </div>

                <button type="button" class="save-btn" onclick="saveSection('Jalur Masuk')">Save</button>
                <div style="clear: both;"></div>
            </div>
        </div>

        <!-- PILIHAN JURUSAN -->
        <div class="form-section">
            <div class="section-header" onclick="toggleFormSection(this)">
                <span>PILIHAN JURUSAN</span>
                <div class="chevron-icon open">∨</div>
            </div>
            <div class="section-body open">
                <!-- Pilihan 1 -->
                <div class="pilihan-section">
                    <h3 class="pilihan-title">Pilihan 1 <span style="color: red;">*</span></h3>
                    <div class="checkbox-group" id="pilihan1-group">
                        <label>
                            <input type="checkbox" name="pilihan_1" value="D4 Bisnis Digital">
                            D4 Bisnis Digital
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_1" value="D3 Teknik Informatika">
                            D3 Teknik Informatika
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_1" value="D4 Akuntansi Bisnis Digital">
                            D4 Akuntansi Bisnis Digital
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_1" value="D3 Teknik Otomotif">
                            D3 Teknik Otomotif
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_1" value="D4 Manajemen Pemasaran Internasional">
                            D4 Manajemen Pemasaran Internasional
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_1" value="D3 Budidaya Tanaman Perkebunan">
                            D3 Budidaya Tanaman Perkebunan
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_1" value="D4 Teknologi Rekayasa Multimedia">
                            D4 Teknologi Rekayasa Multimedia
                        </label>
                    </div>
                </div>

                <!-- Pilihan 2 -->
                <div class="pilihan-section">
                    <h3 class="pilihan-title">Pilihan 2 <span style="color: red;">*</span></h3>
                    <div class="checkbox-group" id="pilihan2-group">
                        <label>
                            <input type="checkbox" name="pilihan_2" value="D4 Bisnis Digital">
                            D4 Bisnis Digital
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_2" value="D3 Teknik Informatika">
                            D3 Teknik Informatika
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_2" value="D4 Akuntansi Bisnis Digital">
                            D4 Akuntansi Bisnis Digital
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_2" value="D3 Teknik Otomotif">
                            D3 Teknik Otomotif
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_2" value="D4 Manajemen Pemasaran Internasional">
                            D4 Manajemen Pemasaran Internasional
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_2" value="D3 Budidaya Tanaman Perkebunan">
                            D3 Budidaya Tanaman Perkebunan
                        </label>
                        <label>
                            <input type="checkbox" name="pilihan_2" value="D4 Teknologi Rekayasa Multimedia">
                            D4 Teknologi Rekayasa Multimedia
                        </label>
                    </div>
                </div>

                <button type="button" class="save-btn" onclick="saveSection('Pilihan Jurusan')">Save</button>
                <div style="clear: both;"></div>
            </div>
        </div>

        <button type="submit" class="done-btn">Done</button>
    </form>
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

        // Make checkboxes work like radio buttons (only one can be selected per group)
        setupCheckboxGroups();
    });

    function setupCheckboxGroups() {
        // Handle Pilihan 1
        const pilihan1Group = document.getElementById('pilihan1-group');
        if (pilihan1Group) {
            const pilihan1Checkboxes = pilihan1Group.querySelectorAll('input[type="checkbox"]');
            
            pilihan1Checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        pilihan1Checkboxes.forEach(function(cb) {
                            if (cb !== checkbox) {
                                cb.checked = false;
                            }
                        });
                    }
                });
            });
        }

        // Handle Pilihan 2
        const pilihan2Group = document.getElementById('pilihan2-group');
        if (pilihan2Group) {
            const pilihan2Checkboxes = pilihan2Group.querySelectorAll('input[type="checkbox"]');
            
            pilihan2Checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        pilihan2Checkboxes.forEach(function(cb) {
                            if (cb !== checkbox) {
                                cb.checked = false;
                            }
                        });
                    }
                });
            });
        }
    }
</script>
@endsection