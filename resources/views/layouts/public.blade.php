<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-dark-mesh {
            background-color: #0b0f1a;
            background-image:
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.12) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.12) 0, transparent 50%);
            background-attachment: fixed;
        }

        .glass-panel {
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(30, 41, 59, 0.8);
        }

        .glass-header {
            background-color: rgba(11, 15, 26, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(30, 41, 59, 0.8);
        }
    </style>
</head>
<body class="bg-dark-mesh min-h-screen text-slate-300 overflow-hidden">

    <header class="fixed top-0 w-full z-50 glass-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-violet-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/20 mr-3">
                        <img src="{{ asset('img/logo.png') }}" alt="S" class="w-full h-full object-contain p-1">
                    </div>
                    <span class="text-xl font-bold text-white tracking-wide">{{ config('app.name') }}</span>
                </div>

                @yield('header-actions')
            </div>
        </div>
    </header>

    <main class="pt-20 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            @yield('content')
        </div>
    </main>

    @stack('scripts')

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
