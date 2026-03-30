@extends('layouts.public')

@section('title', 'Posters Publicados - SIGEC')

@section('header-actions')
    @auth
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Volver</span>
        </a>
    @endauth
    @guest
        <a href="{{ route('home') }}"
            class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
            <i data-lucide="user" class="w-4 h-4"></i>
            <span>Login</span>
        </a>
    @endguest
@endsection

@section('content')
    <div class="h-screen overflow-y-auto">
        <div class="transform translate-z-0">
            <div class="mb-6 text-center sticky top-0 z-50 pt-4 glass-header pb-4">
                <h1 class="text-4xl font-bold text-white tracking-tight mb-8">Posters Científicos Publicados</h1>
                <div class="glass-panel p-4 rounded-2xl max-w-5xl mx-auto">
                    <form method="GET" action="{{ route('posters.search') }}" class="flex flex-col md:flex-row items-stretch md:items-end gap-4">
                        <div class="w-full md:flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="search" class="w-5 h-5 text-slate-500"></i>
                                </div>
                                <input type="text" id="searchInput" name="title" placeholder="Buscar por título ..."
                                    class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-xl leading-5 bg-slate-900/50 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 text-slate-300 sm:text-sm transition-all">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                            <div class="w-full md:w-48">
                                <select id="categorySelect"
                                    name="category"
                                    class="block w-full pl-3 pr-10 py-3 text-base border-slate-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-xl bg-slate-900/50 text-slate-300">
                                    <option value="" class="bg-slate-800" selected>Ninguna</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" class="bg-slate-800">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full md:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                                <i data-lucide="filter" class="w-4 h-4"></i>
                                <span>Filtrar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="space-y-6" id="postersGrid">
                @forelse($posters as $poster)
                    <x-poster-card
                        :title="$poster->title"
                        :summary="$poster->summary"
                        :user="$poster->user->name"
                        :category="$poster->category->name"
                        :url="route('posters.show', $poster)"
                    />
                @empty
                    <div class="text-center py-20">
                        <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="file-text" class="w-8 h-8 text-slate-500"></i>
                        </div>
                        <h3 class="text-xl font-medium text-white mb-2">No hay posters disponibles</h3>
                        <p class="text-slate-400">Pronto se publicarán nuevos posters científicos.</p>
                    </div>
                @endforelse
                <!-- Paginación centrado -->
                <div class="flex flex-col md:flex-row justify-center items-center gap-4 mt-6 pb-32">
                    <p class="text-sm text-slate-400 order-2 md:order-1">
                        Mostrando {{ $posters->firstItem() }} - {{ $posters->lastItem() }} de {{ $posters->total() }} posters
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
            </div>
        </div>
    </div>

@endsection
