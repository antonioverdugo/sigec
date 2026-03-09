<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <!-- Content Scroll Area -->
    <div class="flex-1 overflow-y-auto p-6 md:p-10 scroll-smooth">
        <div class="max-w-7xl mx-auto space-y-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">Bienvenido, <?php echo e(Auth::user()->name); ?> ( <?php echo e(ucwords(Auth::user()->role->name)); ?> )</h1>
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
                    <h3 class="text-3xl font-bold text-white"><?php echo e($countUser); ?></h3>
                    
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 hover:border-violet-500/30 transition-colors group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-slate-400 text-sm font-medium">Ponencias Activas</span>
                        <div class="w-8 h-8 rounded-lg bg-violet-500/10 flex items-center justify-center text-violet-500 group-hover:bg-violet-500 group-hover:text-white transition-colors">
                            <i data-lucide="presentation" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white">48</h3>
                    <p class="text-xs text-slate-500 mt-2">8 pendientes de revisión</p>
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 hover:border-emerald-500/30 transition-colors group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-slate-400 text-sm font-medium">Patrocinadores</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                            <i data-lucide="handshake" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white">12</h3>
                    <p class="text-xs text-slate-500 mt-2">Nivel Diamante: 3</p>
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 hover:border-pink-500/30 transition-colors group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-slate-400 text-sm font-medium">Posters Científicos</span>
                        <div class="w-8 h-8 rounded-lg bg-pink-500/10 flex items-center justify-center text-pink-500 group-hover:bg-pink-500 group-hover:text-white transition-colors">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white">156</h3>
                    <p class="text-xs text-green-400 flex items-center mt-2">
                        <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i>
                        +5 hoy
                    </p>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/luciantoniopo/sigec/resources/views/dashboard.blade.php ENDPATH**/ ?>