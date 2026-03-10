<x-app-layout>
    <div class="max-w-full mx-auto p-6 md:p-10 space-y-8">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Gestión de las Categoria</h1>
                <p class="text-slate-400 mt-1">Administra las categorias de las ponencias del sistema</p>
            </div>
            <a href="{{route('categories.create')}}"
                class="inline-flex items-center justify-center space-x-2 px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Crear Categoria</span>
            </a>
        </div>

        <!-- Table (Responsive Grid) -->
        <div class="glass-panel rounded-2xl border border-slate-800 overflow-hidden">
            <!-- Desktop Header -->
            <div class="hidden md:grid md:grid-cols-4 gap-2 px-6 py-4 border-b border-slate-800 bg-slate-900/30">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Categoria</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Descripcion</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Fecha</div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Acciones</div>
            </div>

            <!-- Categorias -->
            <div class="divide-y divide-slate-800">
                <!-- Recorrer las categorias -->
                @forelse($categories as $category)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-2 px-6 py-4 hover:bg-slate-800/30 transition-colors">
                        <div class="flex items-center space-x-3">
                            <!-- Pintar las iniciales de la categoria y su nombre -->
                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-semibold border-2 border-slate-700">
                                {{ collect(explode(' ', $category->name))->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                            </div>
                            <span class="text-sm font-medium text-white break-words">{{ $category->name }}</span>
                        </div>
                        <!-- Pintar la descripcion -->
                        <div class="text-sm text-slate-300 text-center break-words">
                            <p>{{ $category->description }}</p>
                        </div>
                        <!--Pintar la fecha de creacion de la categoria-->
                        <div class="text-sm text-slate-400 text-center"><span class="md:hidden">Fecha: </span>{{ $category->created_at->format('d-m-Y') }}</div>
                        <!--Pintar las acciones de CRUD-->
                        <div class="flex items-center justify-end space-x-2">
                             <!-- <a class="p-2 text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg"><i data-lucide="eye" class="w-4 h-4"></i></a> -->
                            <a href="{{route('categories.edit', ['category'=>$category->id])}}" title="Editar Categoria" class="p-2 text-slate-400 hover:text-amber-400 hover:bg-amber-500/10 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                            <form action="{{ route('categories.destroy', [$category]) }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button title="Eliminar Categoria" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
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
            Mostrando {{ $categories->firstItem() }} - {{ $categories->lastItem() }} de {{ $categories->total() }} categorias
        </p>

        <nav class="flex gap-2 order-1 md:order-2">
            {{-- Botón Anterior --}}
            @if ($categories->onFirstPage())
                <span class="px-4 py-2 text-sm text-slate-600 bg-slate-800/50 rounded-lg cursor-not-allowed">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </span>
            @else
                <a href="{{ $categories->previousPageUrl() }}" class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
            @endif

           <!-- Numeros de paginas -->
            @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                @if ($page == $categories->currentPage())
                    <span class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">{{ $page }}</a>
                @endif
            @endforeach

           <!-- Botón siguiente -->
            @if ($categories->hasMorePages())
                <a href="{{ $categories->nextPageUrl() }}" class="px-4 py-2 text-sm text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors">
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
