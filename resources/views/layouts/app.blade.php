<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('img/favicon.ico')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
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

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-dark-mesh text-slate-300 flex">
        <!-- Sidebar -->
        <aside
            class="w-64 h-screen glass-panel flex flex-col border-r border-slate-800 transition-transform transform -translate-x-full md:translate-x-0 fixed md:relative z-50"
            id="sidebar">
            <!-- Logo Area -->
            <div class="h-24 flex items-center justify-center border-b border-slate-800/50">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                    <div class="inline-flex items-center justify-center overflow-hidden w-20 h-20 rounded-[1rem]">
                        <img src="{{ asset('img/logo.png') }}" alt="SIGEC Logo"
                            class="w-full h-full object-contain scale-[1.5]">
                    </div>
                </a>
            </div>

            <!-- User Profile with Dropdown -->
            <div class="px-4 py-4 border-b border-slate-800/50" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center space-x-3 hover:bg-slate-800/50 p-2 rounded-xl transition-all">
                    <!-- Pintar las iniciales del usuario y su nombre -->
                    <div
                        class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-semibold border-2 border-slate-700">
                        {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                    </div>
                    <div class="flex-1 text-left">
                        <h4 class="text-sm font-semibold text-white">{{ Auth::user()->name }}<br>(
                            {{ucwords(Auth::user()->role->name)}} )
                        </h4>
                        <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform"
                        :class="{'rotate-180': open}"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false"
                    class="mt-2 py-2 bg-slate-800 rounded-xl border border-slate-700 overflow-hidden"
                    style="display: none;">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-3 px-4 py-3 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-all">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>Editar Perfil</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="w-full flex items-center space-x-3 px-4 py-3 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-red-400 transition-all cursor-pointer">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span>Cerrar Sesión</span>
                        </a>
                    </form>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                @php
                    $activeLink = 'text-blue-400 bg-blue-500/10 border border-blue-500/20 hover:shadow-lg hover:shadow-blue-500/10';
                    $inactiveLink = 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50';
                @endphp
                <!-- Dashboard se muestra para todos los users -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('dashboard') ? $activeLink : $inactiveLink }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                <!-- Usuarios, ponencias y patrocinadores solo si el usuarios es admin -->
                @if (Auth::user()->role->id === 3)
                    <a href="{{ route('users.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('users.*') ? $activeLink : $inactiveLink }}">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span>Usuarios</span>
                    </a>

                    <a href="{{ route('sponsors.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('sponsors.index') ? $activeLink : $inactiveLink }}">
                        <i data-lucide="handshake" class="w-5 h-5"></i>
                        <span>Patrocinadores</span>
                    </a>

                    <a href="{{ route('categories.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('categories.index') ? $activeLink : $inactiveLink }}">
                        <i data-lucide="tag" class="w-5 h-5"></i>
                        <span>Categorias</span>
                    </a>

                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 text-sm font-medium rounded-xl transition-all {{ $inactiveLink }}">
                        <i data-lucide="presentation" class="w-5 h-5"></i>
                        <span>Ponencias Orales</span>
                    </a>
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 text-sm font-medium rounded-xl transition-all {{ $inactiveLink }}">
                        <i data-lucide="scroll" class="w-5 h-5"></i>
                        <span>Posters Cientificos</span>
                    </a>

                @endif

                <!-- Ponencias y posters solo si el usuarios es ponente -->
                @if (Auth::user()->role->id === 2)

                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 text-sm font-medium rounded-xl transition-all {{ $inactiveLink }}">
                        <i data-lucide="presentation" class="w-5 h-5"></i>
                        <span>Mis Ponencias</span>
                    </a>
                    <a href="#"
                        class="flex items-center space-x-3 px-4 py-3 text-sm font-medium rounded-xl transition-all {{ $inactiveLink }}">
                        <i data-lucide="presentation" class="w-5 h-5"></i>
                        <span>Mis Poster Científicos</span>
                    </a>
                @endif
            </nav>

            <!-- Bottom Actions -->
            <div class="p-4 border-t border-slate-800/50">
                <a href="#"
                    class="w-full flex items-center justify-center space-x-2 px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 rounded-xl shadow-lg shadow-violet-600/20 transition-all active:scale-95">
                    <i data-lucide="scroll" class="w-4 h-4"></i>
                    <span>Posters Científicos</span>
                </a>
            </div>

            <!-- Footer -->
            <footer class="p-4 border-t border-slate-800/50 text-center">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} Antonio Ramón Verdugo García</p>
            </footer>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
            <!-- Mobile Header -->
            <header
                class="h-16 md:hidden flex items-center justify-between px-4 border-b border-slate-800 glass-panel z-40">
                <span class="text-lg font-bold text-white">SIGEC</span>
                <button id="menu-btn" class="text-slate-300 focus:outline-none">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </header>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto">
                {{ $slot }}
            </div>
        </main>

        <!-- Overlay for mobile sidebar -->
        <div id="overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden md:hidden"></div>

        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons();

            const menuBtn = document.getElementById('menu-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            function toggleSidebar() {
                const isClosed = sidebar.classList.contains('-translate-x-full');
                if (isClosed) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            }

            if (menuBtn) {
                menuBtn.addEventListener('click', toggleSidebar);
                overlay.addEventListener('click', toggleSidebar);
            }
        </script>
    </div>
    <!-- Mostrar mensaje de confirmacion con sweetalert2-->
    @if(($mensaje = Session::get('message')) && ($icono = Session::get('icon')))
        <script>
            Swal.fire({
                position: "center",
                icon: "{{ $icono }}",
                title: "{{ $mensaje }}",
                showConfirmButton: true,
            });
        </script>
    @endif
</body>

</html>
