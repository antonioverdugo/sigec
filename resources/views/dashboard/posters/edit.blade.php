<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 md:p-10 space-y-8">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Editar un Póster Científico</h1>
                <p class="text-slate-400 mt-1">Introduce los datos y edita el póster científico</p>
            </div>
            <a href="{{route('posters.index')}}"
                class="inline-flex items-center justify-center space-x-2 px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <span>Cancelar</span>
            </a>
        </div>
        <!-- Formulario Actualizar un poster -->
        <div class="glass-panel p-8 rounded-2xl border border-slate-800">
            <form method="POST" action="{{ route('posters.update', ['poster' => $poster]) }}" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Titulo -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-300 mb-2">Título *</label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $poster->title) }}"
                        oninvalid="this.setCustomValidity('Por favor ingrese un titulo')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Ingresa el título del póster científico">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Resumen del poster -->
                <div>
                    <label for="summary" class="block text-sm font-medium text-slate-300 mb-2">Resumen del Poster *</label>
                    <textarea
                      name="summary"
                      id="summary"
                      rows="5"
                      cols="50"
                      placeholder="Escribe el resumen del póster aquí..."
                      oninvalid="this.setCustomValidity('Por favor ingrese un resumen del póster')"
                      oninput="this.setCustomValidity('')"
                      class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                      required
                    > {{ old('summary', $poster->summary) }}</textarea>
                    @error('summary')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoria del poster -->
                <div>
                    <label for="category" class="block text-sm font-medium text-slate-300 mb-2">Categoria </label>
                    <select name="category" id="category"
                        oninvalid="this.setCustomValidity('Por favor seleccione una categoria')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                        <option value="" class="bg-slate-800" disabled selected>Selecciona una categoria</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="bg-slate-800" {{ old('category', $poster->category_id) == $category->id ? 'selected' : '' }}>{{ ucwords($category->name) }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Archivo del poster -->
                <div>
                    <label for="file" class="block text-sm font-medium text-slate-300 mb-2">Subir Archivo Póster (opcional si no se elige un archivo se mantendrá el subido anteriormente)</label>
                    <input type="file" name="file" id="file" value=""
                        oninvalid="this.setCustomValidity('Por favor seleccione un archivo')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Seleccione el archivo de su póster"
                        accept=".pdf">
                    @error('file')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center space-x-2 px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Actualizar Póster</span>
                    </button>
                    <a href="{{ route('posters.index') }}"
                        class="flex-1 inline-flex items-center justify-center space-x-2 px-6 py-3 text-sm font-semibold text-slate-300 bg-slate-700 hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                        <span>Cancelar</span>
                    </a>
                </div>
            </form>
        </div>
</x-app-layout>
