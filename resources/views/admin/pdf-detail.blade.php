<html>
<head>
    <meta charset="utf-8">
    <title>Detail Pendaftar</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
         .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 25px;
            color: #1e5a96;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background: #1e5a96;
            color: white;
            padding: 8px;
            font-size: 14px;
             font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #ccc;
            padding: 8px;
            vertical-align: top;
        }
td.label {
            width: 30%;
            font-weight: bold;
            background: #f5f5f5;
        }
    </style>
</head>
<body>

    <div class="title">DETAIL PENDAFTAR</div>

    {{-- DATA DIRI --}}
    <div class="section">
        <div class="section-title">Data Diri</div>

        <table>
            <tr>
    <td class="label">Foto</td>
    <td>
        @if($camaba->photo)
            <img src="{{ public_path('storage/' . $camaba->photo) }}"
                 width="120"
                 style="border:1px solid #000;">
        @else
            -
        @endif
    </td>
</tr>
            <tr>
                 <td class="label">Nama Lengkap</td>
                <td>{{ $camaba->personalData->full_name ?? '-' }}</td>
            </tr>
            
            <tr>
                 <td class="label">Alamat Lengkap</td>
                <td>{{ $camaba->personalData->address ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Tempat Lahir</td>
                <td>{{ $camaba->personalData->place_of_birth ?? '-' }}</td>
            </tr>
            
            <tr>
                <td class="label">Telepon/HP</td>
                <td>{{ $camaba->personalData->phone ?? '-' }}</td>
            </tr>
            
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td>{{ $camaba->personalData->gender ?? '-' }}</td>
            </tr>
            
            <tr>
                <td class="label">Agama</td>
                <td>{{ $camaba->personalData->religion ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">No. Kartu Keluarga</td>
                <td>{{ $camaba->personalData->kk_number ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">NIK</td>
                <td>{{ $camaba->personalData->nik ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Tanggal Lahir</td>
                <td>{{ $camaba->personalData->date_of_birth ?? '-' }}</td>
            </tr>
        </table>
    </div>
    {{-- PENDIDIKAN --}}
    <div class="section">
        <div class="section-title">Pendidikan</div>

        <table>
            <tr>
                <td class="label">Sekolah Asal</td>
                <td>{{ $camaba->educationData->school_name ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Nomor Pokok Sekolah Nasional (NPSN)</td>
                <td>{{ $camaba->educationData->school_code ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Alamat Sekolah</td>
                <td>{{ $camaba->educationData->school_address ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Jurusan/Program Keahlian</td>
                <td>{{ $camaba->educationData->major ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Tahun Masuk</td>
                <td>{{ $camaba->educationData->year_of_entry?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Prestasi Akademik dan Nilai Akademik</td>
                <td>{{ $camaba->educationData->achievement?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Nomor Induk Siswa Nasional (NISN)</td>
                <td>{{ $camaba->educationData->nisn ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- KELUARGA --}}
    <div class="section">
        <div class="section-title">Data Keluarga</div>
        <table>
            <tr>
                <td class="label">Nama Ayah/Wali</td>
                <td>{{ $camaba->familyData->father_name ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Jumlah Anak</td>
                <td>{{ $camaba->familyData->number_of_children ?? '-' }}</td>
            </tr>

             <tr>
                <td class="label">Pekerjaan Ayah</td>
                <td>{{ $camaba->familyData->father_job ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Anak Ke</td>
                <td>{{ $camaba->familyData->child_order ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Nama Ibu/Wali</td>
                <td>{{ $camaba->familyData->mother_name ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Penghasilan Ayah dan Ibu</td>
                <td>{{ $camaba->familyData->parent_income ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Pekerjaan Ibu</td>
                <td>{{ $camaba->familyData->mother_job ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Alamat</td>
                <td>{{ $camaba->familyData->parent_address ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Nomor HP</td>
                <td>{{ $camaba->familyData->parent_phone ?? '-' }}</td>
            </tr>
        </table>
    </div>
    {{-- JALUR MASUK --}}
    <div class="section">
        <div class="section-title">Jalur Masuk</div>

        <table>
            <tr>
                <td class="label">Jalur Masuk</td>
                <td>{{$camaba->admissionPath->path_name ?? '-' }}</td>
            </tr>
        </table>
    </div>
     {{-- PROGRAM STUDI --}}
    <div class="section">
        <div class="section-title">Program Studi</div>

        <table>
            <tr>
                <td class="label">Pilihan 1</td>
                <td>{{ $camaba->programSelection->program1->program_name ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Pilihan 2</td>
                <td>{{ $camaba->programSelection->program2->program_name ?? '-' }}</td>
            </tr>
        </table>
    </div>
    </body>
</html>