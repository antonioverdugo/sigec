<div class="glass-panel rounded-2xl border border-slate-800 p-8 hover:border-slate-700 transition-all">
    <h3 class="text-2xl font-semibold text-white mb-4 leading-tight">{{ $title }}</h3>

    <p class="text-slate-400 text-sm mb-6 line-clamp-3">{{ $summary }}</p>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-4 border-t border-slate-800">
        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
            <div class="flex items-center gap-1.5 text-slate-400">
                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                <span class="text-sm">{{ $user }}</span>
            </div>
            <span class="hidden md:block text-slate-600">|</span>
            <div class="flex items-center gap-1.5">
                <i data-lucide="tag" class="w-3.5 h-3.5 text-blue-400"></i>
                <span class="text-xs font-medium text-blue-400">{{ $category }}</span>
            </div>
        </div>
        <a href="{{ $url }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
            <i data-lucide="eye" class="w-4 h-4"></i>
            <span>Ver</span>
        </a>
    </div>
</div>
