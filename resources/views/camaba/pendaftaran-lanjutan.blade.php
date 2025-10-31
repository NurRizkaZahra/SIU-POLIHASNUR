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
        max-height: none; /* Ubah dari 2500px ke none */
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

    /* Perbaikan untuk checkbox container */
    .checkbox-container {
        max-height: 300px; /* Batasi tinggi */
        overflow-y: auto; /* Enable scroll */
        padding-right: 10px;
        margin-top: 8px;
    }

    /* Custom scrollbar */
    .checkbox-container::-webkit-scrollbar {
        width: 8px;
    }

    .checkbox-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .checkbox-container::-webkit-scrollbar-thumb {
        background: #1e5a96;
        border-radius: 10px;
    }

    .checkbox-container::-webkit-scrollbar-thumb:hover {
        background: #0d3d6b;
    }

    .checkbox-group {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
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
        flex-shrink: 0; /* Prevent checkbox from shrinking */
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

    .done-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        padding-bottom: 50px;
    }

    .done-btn {
        background: white;
        color: #009347;
        border: 3px solid #009347;
        padding: 12px 60px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 8px rgba(0, 153, 71, 0.2);
    }

    .done-btn:hover {
        background: #009347;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 153, 71, 0.3);
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

        .done-btn {
            padding: 12px 40px;
            font-size: 16px;
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

    <form action="{{ route('camaba.entry-path.save') }}" method="POST">
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

                @php
                $jalurList = [
                    'Mandiri',
                    'Beasiswa Unggulan',
                    'Berdikari',
                    'KIP-Kuliah'
                ];
                @endphp

                @foreach ($jalurList as $jalur)
                    <label>
                        <input type="radio" name="path_name" value="{{ $jalur }}" 
                        {{ isset($path) && $path->path_name == $jalur ? 'checked' : '' }}
                        required>
                        {{ $jalur }}
                    </label>
                @endforeach

            </div>
        </div>

        <button type="submit" class="save-btn">Save</button>
    </div>
</div>

</form>

    <!-- PILIHAN JURUSAN -->
<form action="{{ route('camaba.study-program.save') }}" method="POST">
    @csrf
    <div class="form-section">
        <div class="section-header" onclick="toggleFormSection(this)">
            <span>PILIHAN JURUSAN</span>
            <div class="chevron-icon open">∨</div>
        </div>
        <div class="section-body open">

            <!-- Pilihan 1 -->
            <div class="pilihan-section">
                <h3 class="pilihan-title">Pilihan 1 <span style="color: red;">*</span></h3>
                <div class="checkbox-container">
                    <div class="checkbox-group" id="pilihan1-group">
                       @foreach ($studyPrograms as $program)
    <label>
        <input type="checkbox" 
               name="id_program_1" 
               value="{{ $program->id_program }}"
               {{ isset($programTerpilih) && $programTerpilih->id_program_1 == $program->id_program ? 'checked' : '' }}>
        {{ $program->program_name }}
    </label>
@endforeach

                    </div>
                </div>
            </div>

            <!-- Pilihan 2 -->
            <div class="pilihan-section">
                <h3 class="pilihan-title">Pilihan 2 <span style="color: red;">*</span></h3>
                <div class="checkbox-container">
                    <div class="checkbox-group" id="pilihan2-group">
                        @foreach ($studyPrograms as $program)
    <label>
        <input type="checkbox" 
               name="id_program_2" 
               value="{{ $program->id_program }}"
               {{ isset($programTerpilih) && $programTerpilih->id_program_2 == $program->id_program ? 'checked' : '' }}>
        {{ $program->program_name }}
    </label>
@endforeach

                    </div>
                </div>
            </div>

            <button type="submit" class="save-btn">Save</button>
        </div>
    </div>
</form>


<!-- Done Button di dalam container, bukan fixed -->
<div class="done-wrapper">
    <a href="{{ route('camaba.dashboard') }}" class="done-btn">Done</a>
</div>

<script>
    function toggleFormSection(header) {
        const body = header.nextElementSibling;
        const chevron = header.querySelector('.chevron-icon');
        
        body.classList.toggle('open');
        chevron.classList.toggle('open');
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