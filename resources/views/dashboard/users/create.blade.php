<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 md:p-10 space-y-8">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Crear un Usuario</h1>
                <p class="text-slate-400 mt-1">Introduce los datos y crea un usuario</p>
            </div>
            <a href="{{route('users.index')}}"
                class="inline-flex items-center justify-center space-x-2 px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <span>Cancelar</span>
            </a>
        </div>
        <!-- Formulario Creacion Usuario -->
        <div class="glass-panel p-8 rounded-2xl border border-slate-800">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nombre</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        oninvalid="this.setCustomValidity('Por favor ingrese un nombre')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Ingresa el nombre del usuario">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Correo Electrónico</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        oninvalid="this.setCustomValidity('Por favor ingrese un email válido')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="correo@ejemplo.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        oninvalid="this.setCustomValidity('Por favor introduce un password válido')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rol -->
                <div>
                    <label for="role_id" class="block text-sm font-medium text-slate-300 mb-2">Rol</label>
                    <select name="role_id" id="role_id" required
                        oninvalid="this.setCustomValidity('Por favor seleccione un rol')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                        <option value="" class="bg-slate-800" disabled selected>Selecciona un rol</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" class="bg-slate-800" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ ucwords($role->name) }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center space-x-2 px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Crear Usuario</span>
                    </button>
                    <a href="{{ route('users.index') }}"
                        class="flex-1 inline-flex items-center justify-center space-x-2 px-6 py-3 text-sm font-semibold text-slate-300 bg-slate-700 hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                        <span>Cancelar</span>
                    </a>
                </div>
            </form>
        </div>
</x-app-layout>
