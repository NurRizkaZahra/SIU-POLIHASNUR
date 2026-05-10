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



            <tr>
                <td class="label">Alamat</td>
                <td>{{ $camaba->personalData->address ?? '-' }}</td>
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
                <td class="label">NPSN</td>
                <td>{{ $camaba->educationData->school_code ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td>{{ $camaba->educationData->nisn ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Jurusan</td>
                <td>{{ $camaba->educationData->major ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- KELUARGA --}}
    <div class="section">
        <div class="section-title">Data Keluarga</div>
        <table>
            <tr>
                <td class="label">Nama Ayah</td>
                <td>{{ $camaba->familyData->father_name ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Nama Ibu</td>
                <td>{{ $camaba->familyData->mother_name ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Penghasilan Orang Tua</td>
                <td>{{ $camaba->familyData->parent_income ?? '-' }}</td>
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