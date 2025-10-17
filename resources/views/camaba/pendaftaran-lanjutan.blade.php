<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pendaftaran Lanjutan - SIU Polihasnur</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e0e6adad.js" crossorigin="anonymous"></script>
  <script>
    function toggleSection(id) {
      const section = document.getElementById(id);
      section.classList.toggle('hidden');
    }
  </script>
</head>

<body class="flex min-h-screen bg-blue-200">
  <!-- Sidebar -->
  <aside class="flex flex-col w-64 p-4 text-white bg-blue-900">
    <h2 class="mb-6 text-lg font-bold">SIU-POLIHASNUR</h2>

    <div class="flex flex-col items-center mb-6">
      <div class="flex items-center justify-center w-16 h-16 text-2xl font-bold text-blue-900 bg-yellow-400 rounded-full">
        C
      </div>
      <p class="mt-2 text-sm font-semibold">Camaba</p>
      <p class="text-xs">Nur Rizka Zahra</p>
    </div>

    <nav class="space-y-3">
      <a href="#" class="flex items-center gap-2 hover:text-yellow-300">
        <i class="fa fa-home"></i> <span>Beranda</span>
      </a>
      <a href="#" class="flex items-center gap-2 font-semibold text-yellow-400">
        <i class="fa fa-edit"></i> <span>Pendaftaran</span>
      </a>
      <a href="#" class="flex items-center gap-2 hover:text-yellow-300">
        <i class="fa fa-calendar"></i> <span>Jadwal Ujian</span>
      </a>
      <a href="#" class="flex items-center gap-2 hover:text-yellow-300">
        <i class="fa fa-file-alt"></i> <span>Ujian</span>
      </a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-8 bg-white shadow-lg rounded-l-3xl">

    <!-- Jalur Masuk -->
    <div class="mb-6 border border-blue-300 shadow-sm rounded-xl">
      <div onclick="toggleSection('jalurMasuk')" class="flex items-center justify-between p-3 font-semibold text-white bg-blue-800 cursor-pointer rounded-t-xl">
        <span>JALUR MASUK</span>
        <i class="fa fa-chevron-down"></i>
      </div>
      <div id="jalurMasuk" class="p-4 space-y-3">
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
          <label class="flex items-center space-x-2">
            <input type="radio" name="jalur" value="mandiri" class="text-blue-600"> <span>Mandiri</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="radio" name="jalur" value="berdikari" class="text-blue-600"> <span>Berdikari</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="radio" name="jalur" value="beasiswa" class="text-blue-600"> <span>Beasiswa Unggulan</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="radio" name="jalur" value="kip" class="text-blue-600"> <span>KIP-Kuliah</span>
          </label>
        </div>
        <div class="flex justify-end mt-4">
          <button type="button" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Save</button>
        </div>
      </div>
    </div>

    <!-- Pilihan Jurusan -->
    <div class="border border-blue-300 shadow-sm rounded-xl">
      <div onclick="toggleSection('pilihanJurusan')" class="flex items-center justify-between p-3 font-semibold text-white bg-blue-800 cursor-pointer rounded-t-xl">
        <span>PILIHAN JURUSAN</span>
        <i class="fa fa-chevron-down"></i>
      </div>
      <div id="pilihanJurusan" class="p-4 space-y-6">
        <div>
          <h3 class="mb-2 font-semibold text-blue-700">Pilihan 1</h3>
          <div class="grid grid-cols-2 gap-2 text-sm sm:grid-cols-3">
            <label><input type="radio" name="pilihan1" value="D3 Teknik Otomotif" class="mr-1"> D3 Teknik Otomotif</label>
            <label><input type="radio" name="pilihan1" value="D3 Teknik Informatika" class="mr-1"> D3 Teknik Informatika</label>
            <label><input type="radio" name="pilihan1" value="D3 Budidaya Tanaman Perkebunan" class="mr-1"> D3 Budidaya Tanaman Perkebunan</label>
            <label><input type="radio" name="pilihan1" value="D4 Bisnis Digital" class="mr-1"> D4 Bisnis Digital</label>
            <label><input type="radio" name="pilihan1" value="D4 Akuntansi Bisnis Digital" class="mr-1"> D4 Akuntansi Bisnis Digital</label>
            <label><input type="radio" name="pilihan1" value="D4 Manajemen Pemasaran Internasional" class="mr-1"> D4 Manajemen Pemasaran Internasional</label>
            <label><input type="radio" name="pilihan1" value="D4 Teknologi Rekayasa Multimedia" class="mr-1"> D4 Teknologi Rekayasa Multimedia</label>
          </div>
        </div>

        <div>
          <h3 class="mb-2 font-semibold text-blue-700">Pilihan 2</h3>
          <div class="grid grid-cols-2 gap-2 text-sm sm:grid-cols-3">
            <label><input type="radio" name="pilihan2" value="D3 Teknik Otomotif" class="mr-1"> D3 Teknik Otomotif</label>
            <label><input type="radio" name="pilihan2" value="D3 Teknik Informatika" class="mr-1"> D3 Teknik Informatika</label>
            <label><input type="radio" name="pilihan2" value="D3 Budidaya Tanaman Perkebunan" class="mr-1"> D3 Budidaya Tanaman Perkebunan</label>
            <label><input type="radio" name="pilihan2" value="D4 Bisnis Digital" class="mr-1"> D4 Bisnis Digital</label>
            <label><input type="radio" name="pilihan2" value="D4 Akuntansi Bisnis Digital" class="mr-1"> D4 Akuntansi Bisnis Digital</label>
            <label><input type="radio" name="pilihan2" value="D4 Manajemen Pemasaran Internasional" class="mr-1"> D4 Manajemen Pemasaran Internasional</label>
            <label><input type="radio" name="pilihan2" value="D4 Teknologi Rekayasa Multimedia" class="mr-1"> D4 Teknologi Rekayasa Multimedia</label>
          </div>
        </div>

        <div class="flex justify-between mt-6">
          <a href="{{ route('pendaftaran') }}" class="px-4 py-2 text-gray-800 bg-gray-300 rounded-lg hover:bg-gray-400">← Kembali</a>
          <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Done</button>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
