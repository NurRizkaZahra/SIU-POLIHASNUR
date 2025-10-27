<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIU-POLIHASNUR') - Admin Panel</title>

    {{-- Include style untuk admin --}}
    @include('layouts.partials-admin.styles')
    
    {{-- Stack untuk custom styles dari halaman --}}
    @stack('styles')
</head>
<body>
    <div class="container">
        {{-- Sidebar admin --}}
        @include('layouts.partials-admin.sidebar')

        <div class="main-content flex-1">
            {{-- Header admin --}}
            @include('layouts.partials-admin.header')

            {{-- Konten utama --}}
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Script admin --}}
    @include('layouts.partials-admin.scripts')
    
    {{-- Stack untuk custom scripts dari halaman --}}
    @stack('scripts')
</body>
</html>