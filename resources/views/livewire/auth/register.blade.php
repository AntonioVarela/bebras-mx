<x-layouts.auth title="Registrarse - Bebras Lab">
    <div class="flex flex-col gap-6">
        {{-- Título de la tarjeta --}}
        <div class="text-center mb-2">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-2" style="background: linear-gradient(45deg, #FF6B6B, #4ECDC4, #FFE66D); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Crear cuenta
            </h2>
            <p class="text-base text-neutral-700 dark:text-neutral-300 font-semibold">
                Únete a Bebras Lab y empieza a resolver desafíos
            </p>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5" id="registerForm">
            @csrf

            {{-- Nombre --}}
            <div class="group">
                <label for="name" class="block text-sm font-bold text-neutral-800 dark:text-neutral-200 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">👤</span>
                        <span>Tu nombre</span>
                    </div>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-xl">✨</div>
                    <flux:input
                        id="name"
                        name="name"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Tu nombre completo"
                        class="pl-12 text-lg border-2 border-yellow-300 focus:border-pink-400 focus:ring-2 focus:ring-pink-300 rounded-xl transition-all duration-200"
                    />
                </div>
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="group">
                <label for="email" class="block text-sm font-bold text-neutral-800 dark:text-neutral-200 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">📧</span>
                        <span>Tu correo electrónico</span>
                    </div>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-xl">📨</div>
                    <flux:input
                        id="email"
                        name="email"
                        type="email"
                        required
                        autocomplete="email"
                        placeholder="ejemplo@correo.com"
                        class="pl-12 text-lg border-2 border-yellow-300 focus:border-pink-400 focus:ring-2 focus:ring-pink-300 rounded-xl transition-all duration-200"
                    />
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Contraseña --}}
            <div class="group">
                <label for="password" class="block text-sm font-bold text-neutral-800 dark:text-neutral-200 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🔒</span>
                        <span>Tu contraseña secreta</span>
                    </div>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-xl">🔑</div>
                    <flux:input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="Elige una contraseña segura"
                        viewable
                        class="pl-12 text-lg border-2 border-yellow-300 focus:border-pink-400 focus:ring-2 focus:ring-pink-300 rounded-xl transition-all duration-200"
                    />
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div class="group">
                <label for="password_confirmation" class="block text-sm font-bold text-neutral-800 dark:text-neutral-200 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🔐</span>
                        <span>Repite tu contraseña</span>
                    </div>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-xl">🔑</div>
                    <flux:input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="Vuelve a escribir tu contraseña"
                        viewable
                        class="pl-12 text-lg border-2 border-yellow-300 focus:border-pink-400 focus:ring-2 focus:ring-pink-300 rounded-xl transition-all duration-200"
                    />
                </div>
            </div>

            {{-- Botón --}}
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500 hover:from-yellow-500 hover:via-pink-500 hover:to-purple-600 text-white font-bold py-4 px-6 rounded-2xl shadow-2xl hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-3 group mt-2 text-lg border-2 border-white/30"
                data-test="register-user-button"
            >
                <span>¡Únete a Bebras Lab!</span>
                <span class="text-2xl group-hover:animate-bounce">🎉</span>
            </button>
        </form>

        {{-- Enlace a login --}}
        <div class="relative my-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-neutral-300 dark:border-neutral-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white dark:bg-neutral-900 text-neutral-500 dark:text-neutral-400">o</span>
            </div>
        </div>

        <div class="text-center">
            <p class="text-sm text-neutral-700 dark:text-neutral-300 font-semibold">
                ¿Ya tienes cuenta? 🤔
                <flux:link
                    :href="route('login')"
                    wire:navigate
                    class="font-bold text-pink-600 hover:text-purple-600 dark:text-pink-400 dark:hover:text-purple-400 transition-colors text-lg"
                >
                    Inicia sesión
                </flux:link>
            </p>
        </div>
    </div>
</x-layouts.auth>
