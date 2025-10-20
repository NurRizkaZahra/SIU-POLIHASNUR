<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIU-POLIHASNUR')</title>
    
    @include('layouts.partials.styles')
    @stack('styles')
</head>
<body>
    <div class="container">
        @include('layouts.partials.sidebar')
        
        <div class="main-content">
            @include('layouts.partials.header')
            
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    @include('layouts.partials.scripts')
    @stack('scripts')
</body>
</html>
