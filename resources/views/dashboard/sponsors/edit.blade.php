<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 md:p-10 space-y-8">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Actualizar un Patrocinador</h1>
                <p class="text-slate-400 mt-1">Introduce los datos y actualiza un patrocinador</p>
            </div>
            <a href="{{route('sponsors.index')}}"
                class="inline-flex items-center justify-center space-x-2 px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                <span>Cancelar</span>
            </a>
        </div>
        <!-- Formulario Creacion Patrocinador -->
        <div class="glass-panel p-8 rounded-2xl border border-slate-800">
            <form method="POST" action="{{ route('sponsors.update', $sponsor) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nombre</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $sponsor->name) }}"
                        oninvalid="this.setCustomValidity('Por favor ingrese un nombre')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Ingresa el nombre del patrocinador">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Correo Electrónico</label>
                    <input type="email" name="email" id="email" required value="{{ old('email', $sponsor->email) }}"
                        oninvalid="this.setCustomValidity('Por favor ingrese un email válido')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="correo@ejemplo.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telefono -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-300 mb-2">Teléfono</label>
                    <input type="tel" name="phone" id="phone"
                        oninvalid="this.setCustomValidity('Por favor introduce un teléfono válido')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="9 digitos"
                        value="{{ old('phone', $sponsor->phone === null ? '' : $sponsor->phone) }}">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cantidad Aportada -->
                <div>
                    <label for="amount_contributed" class="block text-sm font-medium text-slate-300 mb-2">Cantidad Aportada</label>
                    <input type="number" name="amount_contributed" id="amount_contributed"
                        oninvalid="this.setCustomValidity('Por favor introduce un numero válido')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Valores numéricos"
                        value="{{old('amount_contributed', $sponsor->amount_contributed)}}">
                    @error('amount_contributed')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo de patrocinador-->
                <div>
                    <label for="type_sponsor_id" class="block text-sm font-medium text-slate-300 mb-2">Cantidad Aportada</label>
                    <select name="type_sponsor_id" id="role_id" required
                        oninvalid="this.setCustomValidity('Por favor seleccione un tipo de patrocinador')"
                        oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                        <option value="" class="bg-slate-800" disabled selected>Selecciona un tipo de patrocinador</option>
                        @foreach($typeSponsors as $typeSponsor)
                            <option value="{{ $typeSponsor->id }}" class="bg-slate-800" {{ old('type_sponsor_id', $typeSponsor->id) == $typeSponsor->id ? 'selected' : '' }}>{{ ucwords($typeSponsor->name) }}</option>
                        @endforeach
                    </select>
                    @error('type_sponsor_id')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones envio o cancelacion formulario -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center space-x-2 px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>Actualizar Patrocinador</span>
                    </button>
                    <a href="{{ route('sponsors.index') }}"
                        class="flex-1 inline-flex items-center justify-center space-x-2 px-6 py-3 text-sm font-semibold text-slate-300 bg-slate-700 hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                        <span>Cancelar</span>
                    </a>
                </div>
            </form>
        </div>
</x-app-layout>
