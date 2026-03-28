<x-app-layout>
    <!-- Content Scroll Area -->
    <div class="flex-1 overflow-y-auto p-6 md:p-10 scroll-smooth">
        <div class="max-w-7xl mx-auto space-y-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">Bienvenido, {{ Auth::user()->name }} ( {{ ucwords(Auth::user()->role->name) }} )</h1>
                    <p class="text-slate-400 mt-1">Panel de control de Gestión de Congresos</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 hover:border-blue-500/30 transition-colors group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-slate-400 text-sm font-medium">Usuarios Registrados</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                            <i data-lucide="users" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h4 class="text-2xl font-bold text-white">Total: {{$users['total']}} usuarios</h4>
                    <h4 class="text-2xl font-bold text-white">Admin: {{$users['admin']}} usuarios</h4>
                    <h4 class="text-2xl font-bold text-white">Ponentes: {{$users['speaker']}} usuarios</h4>
                    <h4 class="text-2xl font-bold text-white">Asistentes: {{$users['assistant']}} usuarios</h4>
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 hover:border-violet-500/30 transition-colors group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-slate-400 text-sm font-medium">Ponencias Orales</span>
                        <div class="w-8 h-8 rounded-lg bg-violet-500/10 flex items-center justify-center text-violet-500 group-hover:bg-violet-500 group-hover:text-white transition-colors">
                            <i data-lucide="presentation" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h4 class="text-2xl font-bold text-white">{{$presentations['total']}} ponencias</h4>
                    <h4 class="text-2xl font-bold text-white">{{$presentations['published']}} publicadas</h4>
                    <p class="text-xs text-slate-500 mt-2">{{$presentations['no-published']}} pendientes de revisión</p>
                </div>
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 hover:border-pink-500/30 transition-colors group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-slate-400 text-sm font-medium">Posters Científicos</span>
                        <div class="w-8 h-8 rounded-lg bg-pink-500/10 flex items-center justify-center text-pink-500 group-hover:bg-pink-500 group-hover:text-white transition-colors">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h4 class="text-2xl font-bold text-white">{{$posters['total']}} posters</h4>
                    <h4 class="text-2xl font-bold text-white">{{$posters['published']}} publicados</h4>
                    <p class="text-xs text-slate-500 mt-2">{{$posters['no-published']}} pendientes de revisión</p>
                </div>
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 hover:border-emerald-500/30 transition-colors group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-slate-400 text-sm font-medium">Patrocinadores</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                            <i data-lucide="handshake" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white">{{$sponsors['total']}}</h3>
                    <p class="text-xs text-slate-500 mt-2">Oro: {{$sponsors['oro']}}</p>
                    <p class="text-xs text-slate-500 mt-2">Plata: {{$sponsors['plata']}}</p>
                    <p class="text-xs text-slate-500 mt-2">Bronce: {{$sponsors['bronce']}}</p>
                    <p class="text-xs text-slate-500 mt-2">Colaborador: {{$sponsors['colaborador']}}</p>
                    <p class="text-xs text-slate-500 mt-2">Institucional: {{$sponsors['institucional']}}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
