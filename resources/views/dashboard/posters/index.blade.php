<x-app-layout>
    <div class="max-w-full mx-auto p-6 md:p-10 space-y-8">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            @if (Auth::user()->role->name === 'ponente')
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Gestiona Pósters Científicos</h1>
                <p class="text-slate-400 mt-1">Administra tus pósters</p>
            </div>
            <a href="{{ route('posters.create', ['user' => Auth::user()])}}"
                class="inline-flex items-center justify-center space-x-2 px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Crear Póster</span>
            </a>
            @else
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Gestión de los Pósters Científicos</h1>
                <p class="text-slate-400 mt-1">Administra los pósters del sistema</p>
            </div>
            @endif
        </div>

        <!-- Tabla (Responsive Grid) -->
        <div class="glass-panel rounded-2xl border border-slate-800 overflow-hidden">
            <!-- Desktop Header -->
            <div class="hidden md:grid md:grid-cols-7 gap-2 px-6 py-4 border-b border-slate-800 bg-slate-900/30">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Titulo</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Resumen</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Archivo</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Categoria</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Usuario</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Fecha</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Acciones</div>
            </div>

            <!-- Posters -->
            <div class="divide-y divide-slate-800">
                <!-- Recorrer los posters -->
                @forelse($posters as $poster)
                    <div class="grid grid-cols-1 md:grid-cols-7 gap-2 px-6 py-4 hover:bg-slate-800/30 transition-colors">
                        <div class="flex items-center space-x-3">
                            <!-- Pintar las iniciales del postr -->
                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-semibold border-2 border-slate-700">
                                {{ collect(explode(' ', $poster->title))->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                            </div>
                            <span class="text-sm font-medium text-white break-words">{{ $poster->title }}</span>
                        </div>
                        <!-- Pintar el resumen -->
                        <div class="text-sm text-slate-300 text-center break-words">{{ $poster->summary }}</div>
                        <!-- Pintar el archivo -->
                        <div class="text-center">
                            <span class="md:hidden text-xs text-slate-400">Descargar: </span>
                            <a href="{{ asset($poster->url_file) }}" target="_blank" ><span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">Descargar Poster</span></a>
                        </div>
                        <!-- Pintar la categoria de la poncencia -->
                        <div class="text-sm text-slate-300 text-center break-words">{{ $poster->category->name }}</div>
                        <!-- Pintar el usuario de la poncencia-->
                        <div class="text-sm text-slate-300 text-center break-words">{{ $poster->user->name }}</div>
                        <!--Pintar la fecha de creacion de la ponencia-->
                        <div class="text-sm text-slate-400 text-center"><span class="md:hidden">Fecha: </span>{{ $poster->created_at->format('d-m-Y') }}</div>
                        <!--Pintar las acciones de CRUD-->
                        <div class="flex items-center justify-end space-x-2">
                             <!-- <a class="p-2 text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg"><i data-lucide="eye" class="w-4 h-4"></i></a> -->
                             <!--Si el usuario es ponente puede editar y eliminar la ponencia -->
                            @if (Auth::user()->role->name === 'ponente')
                                @if ($poster->published)
                                    <span class="text-xs text-green-400">Publicado</span>
                                @else
                                    <span class="text-xs text-red-400">No Publicado</span>
                                @endif
                                <a href="{{ route('posters.edit', ['poster' => $poster]) }}" title="Editar Poster" class="p-2 text-slate-400 hover:text-amber-400 hover:bg-amber-500/10 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                                <form action="{{ route('posters.destroy', [$poster]) }}" method="POST" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button title="Eliminar Poster" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </form>
                            @endif
                            <!--Si el usuario es admin puede publicar y despublicar la ponencia -->
                            @if (Auth::user()->role->name === 'admin')
                                <form action="{{ route('posters.publish', $poster) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" title="{{ $poster->published ? 'Despublicar' : 'Publicar' }}"
                                        class="p-2 text-slate-400 hover:{{ $poster->published ? 'text-red' : 'text-blue' }}-400 hover:bg-{{ $poster->published ? 'red' : 'blue' }}-500/10 rounded-lg flex items-center gap-2">
                                        <span class="text-xs">{{ $poster->published ? 'Despublicar' : 'Publicar' }}</span>
                                        @if($poster->published)
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
                       No hay pósters registrados
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Paginación centrado -->
    <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-6">
        <p class="text-sm text-slate-400 order-2 md:order-1">
            Mostrando {{ $posters->firstItem() }} - {{ $posters->lastItem() }} de {{ $posters->total() }} pósters
        </p>

        <nav class="flex gap-2 order-1 md:order-2">
            {{-- Botón Anterior --}}
            @if ($posters->onFirstPage())
                <span class="px-4 py-2 text-sm text-slate-600 bg-slate-800/50 rounded-lg cursor-not-allowed">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </span>
            @else
                <a href="{{ $posters->previousPageUrl() }}" class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
            @endif

           <!-- Numeros de paginas -->
            @foreach ($posters->getUrlRange(1, $posters->lastPage()) as $page => $url)
                @if ($page == $posters->currentPage())
                    <span class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">{{ $page }}</a>
                @endif
            @endforeach

           <!-- Botón siguiente -->
            @if ($posters->hasMorePages())
                <a href="{{ $posters->nextPageUrl() }}" class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">
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
