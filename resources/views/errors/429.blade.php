@extends('layouts.public')

@section('title', '429 - Demasiadas Solicitudes - SIGEC')

@section('content')
    <h1 class="pt-12 pb-8 text-4xl text-center font-bold text-white tracking-tight mb-8">Demasiadas solicitudes en poco tiempo.</h1>
    <div class="text-center">
        @guest
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center space-x-3 px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                <span>Volver</span>
            </a>
        @endguest
        @auth
            <a href="{{ route('posters.public') }}"
                class="inline-flex items-center justify-center space-x-3 px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                <span>Volver</span>
            </a>
        @endauth
    </div>
@endsection
