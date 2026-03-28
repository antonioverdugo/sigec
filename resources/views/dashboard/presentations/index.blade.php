<x-app-layout>
    <div class="max-w-full mx-auto p-6 md:p-10 space-y-8">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            @if (Auth::user()->role->name === 'ponente')
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Gestión de las Ponencias</h1>
                <p class="text-slate-400 mt-1">Administra tus ponencias</p>
            </div>
            <a href="{{ route('presentations.create', ['user' => Auth::user()])}}"
                class="inline-flex items-center justify-center space-x-2 px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Crear Ponencia</span>
            </a>
            @else
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Gestión de las Ponencias</h1>
                <p class="text-slate-400 mt-1">Administra las ponencias del sistema</p>
            </div>
            @endif
        </div>

        <!-- Table (Responsive Grid) -->
        <div class="glass-panel rounded-2xl border border-slate-800 overflow-hidden">
            <!-- Desktop Header -->
            <div class="hidden md:grid md:grid-cols-8 gap-2 px-6 py-4 border-b border-slate-800 bg-slate-900/30">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Titulo</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Resumen</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Archivo</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Typo Archivo</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Categoria</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Usuario</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Fecha</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Acciones</div>
            </div>

            <!-- Ponencias -->
            <div class="divide-y divide-slate-800">
                <!-- Recorrer las ponencias -->
                @forelse($presentations as $presentation)
                    <div class="grid grid-cols-1 md:grid-cols-8 gap-2 px-6 py-4 hover:bg-slate-800/30 transition-colors">
                        <div class="flex items-center space-x-3">
                            <!-- Pintar las iniciales de la poncencia -->
                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-semibold border-2 border-slate-700">
                                {{ collect(explode(' ', $presentation->title))->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                            </div>
                            <span class="text-sm font-medium text-white break-words">{{ $presentation->title }}</span>
                        </div>
                        <!-- Pintar el resumen -->
                        <div class="text-sm text-slate-300 text-center break-words">{{ $presentation->summary }}</div>
                        <!-- Pintar el archivo -->
                        <div class="text-center">
                            <span class="md:hidden text-xs text-slate-400">Descargar: </span>
                            <a href="{{ asset($presentation->url_file) }}" target="_blank" ><span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">Descargar Ponencia</span></a>
                        </div>
                        <!-- Pintar el tipo de archivo -->
                        <div class="text-center">
                            <span class="md:hidden text-xs text-slate-400">Descargar: </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">{{ $presentation->type_file }}</span>
                        </div>
                        <!-- Pintar la categoria de la poncencia -->
                        <div class="text-sm text-slate-300 text-center break-words">{{ $presentation->category->name }}</div>
                        <!-- Pintar el usuario de la poncencia-->
                        <div class="text-sm text-slate-300 text-center break-words">{{ $presentation->user->name }}</div>
                        <!--Pintar la fecha de creacion de la ponencia-->
                        <div class="text-sm text-slate-400 text-center"><span class="md:hidden">Fecha: </span>{{ $presentation->created_at->format('d-m-Y') }}</div>
                        <!--Pintar las acciones de CRUD-->
                        <div class="flex items-center justify-end space-x-2">
                             <!-- <a class="p-2 text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg"><i data-lucide="eye" class="w-4 h-4"></i></a> -->
                             <!--Si el usuario es ponente puede editar y eliminar la ponencia -->
                            @if (Auth::user()->role->name === 'ponente')
                                @if ($presentation->published)
                                    <span class="text-xs text-green-400">Publicada</span>
                                @else
                                    <span class="text-xs text-red-400">No Publicada</span>
                                @endif

                                <a href="{{ route('presentations.edit', ['presentation' => $presentation]) }}" title="Editar Ponencia" class="p-2 text-slate-400 hover:text-amber-400 hover:bg-amber-500/10 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                                <form action="{{ route('presentations.destroy', [$presentation]) }}" method="POST" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button title="Eliminar Ponencia" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </form>
                            @endif
                            <!--Si el usuario es admin puede publicar y despublicar la ponencia -->
                            @if (Auth::user()->role->name === 'admin')
                                <form action="{{ route('presentations.publish', $presentation) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" title="{{ $presentation->published ? 'Despublicar' : 'Publicar' }}"
                                        class="p-2 text-slate-400 hover:{{ $presentation->published ? 'text-red' : 'text-blue' }}-400 hover:bg-{{ $presentation->published ? 'red' : 'blue' }}-500/10 rounded-lg flex items-center gap-2">
                                        <span class="text-xs">{{ $presentation->published ? 'Despublicar' : 'Publicar' }}</span>
                                        @if($presentation->published)
                                            <i data-lucide="eye-off" class="w-4 h-4"></i>
                                        @else
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        @endif
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-slate-400">
                       No hay ponencias registradas
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Paginación centrado -->
    <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-6">
        <p class="text-sm text-slate-400 order-2 md:order-1">
            Mostrando {{ $presentations->firstItem() }} - {{ $presentations->lastItem() }} de {{ $presentations->total() }} ponencias
        </p>

        <nav class="flex gap-2 order-1 md:order-2">
            {{-- Botón Anterior --}}
            @if ($presentations->onFirstPage())
                <span class="px-4 py-2 text-sm text-slate-600 bg-slate-800/50 rounded-lg cursor-not-allowed">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </span>
            @else
                <a href="{{ $presentations->previousPageUrl() }}" class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
            @endif

           <!-- Numeros de paginas -->
            @foreach ($presentations->getUrlRange(1, $presentations->lastPage()) as $page => $url)
                @if ($page == $presentations->currentPage())
                    <span class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">{{ $page }}</a>
                @endif
            @endforeach

           <!-- Botón siguiente -->
            @if ($presentations->hasMorePages())
                <a href="{{ $presentations->nextPageUrl() }}" class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">
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
