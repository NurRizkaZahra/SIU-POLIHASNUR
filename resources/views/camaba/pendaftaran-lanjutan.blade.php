<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Lanjutan - SIU Polihasnur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-3xl p-8 bg-white shadow-lg rounded-xl">
        <h1 class="mb-6 text-2xl font-semibold text-center text-gray-800">Form Pendaftaran Lanjutan</h1>

        <!-- Form Pendaftaran -->
        <form action="{{ route('pendaftaran-lanjutan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-1 text-gray-700">Nomor Identitas (KTP / NISN)</label>
                <input type="text" name="nomor_identitas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block mb-1 text-gray-700">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required></textarea>
            </div>

            <div>
                <label class="block mb-1 text-gray-700">No. HP / WhatsApp</label>
                <input type="text" name="no_hp" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block mb-1 text-gray-700">Upload Pas Foto</label>
                <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="flex justify-between mt-8">
                <a href="{{ route('pendaftaran') }}" class="px-4 py-2 text-gray-700 bg-gray-300 rounded-lg hover:bg-gray-400">← Kembali</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Simpan & Lanjutkan</button>
            </div>
        </form>
    </div>
</body>
</html>
