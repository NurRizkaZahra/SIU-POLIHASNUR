<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">

    <nav class="flex justify-between px-6 py-3 text-white bg-blue-600">
        <h1 class="text-lg font-semibold">Dashboard Admin</h1>
        <a href="{{ route('profile.edit') }}" class="hover:underline">Profil</a>
    </nav>

    <div class="max-w-5xl p-8 mx-auto mt-10 bg-white shadow-md rounded-xl">
        <h2 class="mb-4 text-2xl font-bold">Selamat Datang, Admin 👋</h2>
        <p class="text-gray-700">Ini adalah halaman utama dashboard untuk Admin.</p>

        <div class="mt-6">
            <a href="/" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>
