<x-app-layout>
    <div class="max-w-full mx-auto p-6 md:p-10 space-y-8">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Gestión de Patrocinadores</h1>
                <p class="text-slate-400 mt-1">Administra los patrocinadores del sistema</p>
            </div>
            <a href="{{route('sponsors.create')}}"
                class="inline-flex items-center justify-center space-x-2 px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Crear Patrocinador</span>
            </a>
        </div>

        <!-- Table (Responsive Grid) -->
        <div class="glass-panel rounded-2xl border border-slate-800 overflow-hidden">
            <!-- Desktop Header -->
            <div class="hidden md:grid md:grid-cols-7 gap-2 px-6 py-4 border-b border-slate-800 bg-slate-900/30">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Patrocinador</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Email</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Teléfono</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Tipo Patrocinador</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Cantidad Aportada</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Fecha</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Acciones</div>
            </div>

            <!-- Patrocinadores -->
            <div class="divide-y divide-slate-800">
                <!-- Recorrer los patrocinadores -->
                @forelse($sponsors as $sponsor)
                    <div
                        class="grid grid-cols-2 md:grid-cols-7 gap-2 px-6 py-4 hover:bg-slate-800/30 transition-colors">
                        <div class="flex items-center space-x-3">
                            <!-- Pintar las iniciales del patrocinador y su nombre -->
                            <div
                                class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-semibold border-2 border-slate-700">
                                {{ collect(explode(' ', $sponsor->name))->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                            </div>
                            <span class="text-sm font-medium text-white break-words">{{ $sponsor->name }}</span>
                        </div>
                        <!-- Pintar el email -->
                        <div class="text-sm text-slate-300 text-center break-words">{{ $sponsor->email }}</div>
                        <!-- Pintar el teléfono -->
                        <div class="text-sm text-slate-300 text-center break-words">{{ $sponsor->phone === null ? 'Teléfono no proporcionado' : $sponsor->phone }}</div>
                        <!-- Pintar el tipo de patrocinador -->
                        <div class="text-center">
                            <span class="md:hidden text-xs text-slate-400">Tipo Patrocinador: </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">{{ ucwords($sponsor->type_sponsor->name) }}</span>
                        </div>
                        <!-- Pintar la cantidad aportada -->
                        <div class="text-sm text-slate-300 text-center"><span class="md:hidden">Aportado: </span>{{ number_format($sponsor->amount_contributed, 2) }} €</div>
                        <!--Pintar la fecha de creacion del patrocinador-->
                        <div class="text-sm text-slate-400 text-center"><span class="md:hidden">Fecha:
                            </span>{{ $sponsor->created_at->format('d-m-Y') }}</div>
                        <!--Pintar las acciones de CRUD-->
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{route('sponsors.edit', ['sponsor' => $sponsor->id])}}" title="Editar Patrocinador"
                                class="p-2 text-slate-400 hover:text-amber-400 hover:bg-amber-500/10 rounded-lg"><i
                                    data-lucide="pencil" class="w-4 h-4"></i></a>
                            <form action="{{ route('sponsors.destroy', [$sponsor]) }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button title="Eliminar Patrocinador"
                                    class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg"><i
                                        data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-slate-400">
                        No hay usuarios registrados
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Paginación centrado -->
    <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-6">
        <p class="text-sm text-slate-400 order-2 md:order-1">
            Mostrando {{ $sponsors->firstItem() }} - {{ $sponsors->lastItem() }} de {{ $sponsors->total() }} usuarios
        </p>

        <nav class="flex gap-2 order-1 md:order-2">
            {{-- Botón Anterior --}}
            @if ($sponsors->onFirstPage())
                <span class="px-4 py-2 text-sm text-slate-600 bg-slate-800/50 rounded-lg cursor-not-allowed">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </span>
            @else
                <a href="{{ $sponsors->previousPageUrl() }}"
                    class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
            @endif

            <!-- Numeros de paginas -->
            @foreach ($sponsors->getUrlRange(1, $sponsors->lastPage()) as $page => $url)
                @if ($page == $sponsors->currentPage())
                    <span class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                        class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">{{ $page }}</a>
                @endif
            @endforeach

            <!-- Botón siguiente -->
            @if ($sponsors->hasMorePages())
                <a href="{{ $sponsors->nextPageUrl() }}"
                    class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            @else
                <span class="px-4 py-2 text-sm text-slate-600 bg-slate-800/50 rounded-lg cursor-not-allowed">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </span>
            @endif
        </nav>
    </div>
</x-app-layout>
