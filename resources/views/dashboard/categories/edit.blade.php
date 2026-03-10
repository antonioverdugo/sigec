<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 md:p-10 space-y-8">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Actualizar Categoria</h1>
                <p class="text-slate-400 mt-1">Introduce los datos para actualizar la categoria</p>
            </div>
            <a href="{{route('categories.index')}}"
                class="inline-flex items-center justify-center space-x-2 px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <span>Cancelar</span>
            </a>
        </div>
        <!-- Formulario Actualizacion Categoria de Ponencia -->
        <div class="glass-panel p-8 rounded-2xl border border-slate-800">
            <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nombre *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $category->name) }}"
                        oninvalid="this.setCustomValidity('Por favor ingrese un nombre para la categoria al menos 3 caracteres')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Ingresa el nombre de la categoria">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-300 mb-2">Descripción *</label>
                    <textarea
                      name="description"
                      id="description"
                      rows="5"
                      cols="50"
                      placeholder="Escribe tu descripción aquí..."
                      oninvalid="this.setCustomValidity('Por favor ingrese una descripcion de al menos 3 caracteres')"
                      oninput="this.setCustomValidity('')"
                      class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                      required
                    >{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center space-x-2 px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Actualizar Categoria</span>
                    </button>
                    <a href="{{ route('categories.index') }}"
                        class="flex-1 inline-flex items-center justify-center space-x-2 px-6 py-3 text-sm font-semibold text-slate-300 bg-slate-700 hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                        <span>Cancelar</span>
                    </a>
                </div>
            </form>
        </div>
</x-app-layout>
