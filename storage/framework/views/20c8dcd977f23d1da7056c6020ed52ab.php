<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-dark-mesh {
            background-color: #0b0f1a;
            background-image:
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.12) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.12) 0, transparent 50%);
        }
    </style>
        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="bg-dark-mesh min-h-screen flex items-center justify-center p-4 overflow-x-hidden">
        <div class="w-full max-w-md my-auto">


            <!-- Login Card -->
        <div
            class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 p-8 sm:p-10 rounded-3xl sm:rounded-[2.5rem] shadow-2xl shadow-black/50 space-y-8">
            <!-- Header -->
            <div class="text-center space-y-0">
                <div class="inline-flex items-center justify-center overflow-hidden w-32 h-32 mx-auto rounded-[1.5rem]">
                    <a href="<?php echo e(route('login')); ?>"><img src="<?php echo e(asset('img/logo.png')); ?>" alt="SIGEC Logo" class="w-full h-full object-contain scale-[1.75]"></a>
                </div>
                <h3 class="text-xl font-light text-slate-300 tracking-wide">Sistema Gestión de Congresos</h3>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <?php echo e($slot); ?>

            </div>
            <!-- Solo se muestra si es la vista login -->
            <?php if(request()->routeIs('login')): ?>
            <!-- Footer -->
            <div class="text-center pt-2">
                <p class="text-sm text-slate-400">
                    ¿No tienes una cuenta?
                    <a href="<?php echo e(route('register')); ?>"
                        class="text-blue-400 font-semibold hover:text-blue-300 transition-colors">Regístrate</a>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </body>
</html>
<?php /**PATH /home/luciantoniopo/sigec/resources/views/layouts/guest.blade.php ENDPATH**/ ?>