@extends('layouts.public') @section('title', 'Pósters Publicados - SIGEC')
@section('header-actions')
<a
  href="{{ route('posters.public') }}"
  class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95"
>
  <span>Cerrar Póster</span>
  <i data-lucide="x" class="w-4 h-4"></i>
</a>

@endsection @section('content')
<div class="h-screen">
  <div class="transform translate-z-0">
    <div class="mb-6 text-center sticky top-0 z-50 pt-4 glass-header pb-4">
      <h1 class="text-4xl font-bold text-white tracking-tight mb-8">
        Pósters Científicos Publicados
      </h1>
      <div
        class="glass-panel p-4 rounded-2xl max-w-5xl mx-auto flex items-center gap-4"
      >
        <div class="flex items-center gap-1.5 text-slate-400">
          <i data-lucide="user" class="w-3.5 h-3.5"></i>
          <span class="text-sm"> Autor: {{ $poster->user->name }}</span>
        </div>
        <div class="flex items-center gap-1.5">
          <i data-lucide="tag" class="w-3.5 h-3.5 text-blue-400"></i>
          <span class="text-xs font-medium text-blue-400"
            >{{ $poster->category->name }}</span
          >
        </div>
      </div>
    </div>
    <div class="space-y-6" id="postersGrid">
      <iframe
        src="{{ asset('js/pdfjs/web/viewer.html') }}?file={{ urlencode(asset($poster->url_file)) }}#toolbar=0&navpanes=0"
        width="100%"
        height="800px"
      ></iframe>
    </div>
  </div>
</div>

@endsection
