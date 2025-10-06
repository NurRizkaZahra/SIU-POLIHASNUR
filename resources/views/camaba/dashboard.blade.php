<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Camaba</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-50">

    <nav class="flex justify-between px-6 py-3 text-white bg-green-600">
        <h1 class="text-lg font-semibold">Dashboard Camaba</h1>
        <a href="{{ route('profile.edit') }}" class="hover:underline">Profil</a>
    </nav>

    <div class="max-w-5xl p-8 mx-auto mt-10 bg-white shadow-md rounded-xl">
        <h2 class="mb-4 text-2xl font-bold">Halo, Calon Mahasiswa Baru 👋</h2>
        <p class="text-gray-700">Selamat datang di dashboard Camaba. Silakan lengkapi data pendaftaranmu.</p>

        <div class="mt-6">
            <a href="/" class="px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>
