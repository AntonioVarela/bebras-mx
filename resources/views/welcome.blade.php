<x-layouts.auth title="Bienvenido - Bebras Lab">
    <div class="flex flex-col gap-8 text-center">
        {{-- Hero minimalista --}}
        <div>
            <h2 class="text-3xl md:text-5xl font-extrabold mb-3 leading-tight" style="background: linear-gradient(45deg, #FF6B6B, #4ECDC4, #FFE66D); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                ¡Bienvenido a Bebras Lab! 👋
            </h2>
            <p class="text-lg text-neutral-700 dark:text-neutral-300 font-medium max-w-sm mx-auto">
                Desarrolla tu pensamiento computacional con problemas divertidos y desafiantes.
            </p>
        </div>

        {{-- Tres puntos en una sola línea (iconos + título corto) --}}
        <div class="flex flex-wrap justify-center gap-6 md:gap-8">
            <div class="flex flex-col items-center gap-1">
                <span class="text-4xl" aria-hidden="true">🧩</span>
                <span class="text-sm font-bold text-neutral-800 dark:text-white">Resuelve</span>
            </div>
            <div class="flex flex-col items-center gap-1">
                <span class="text-4xl" aria-hidden="true">🏆</span>
                <span class="text-sm font-bold text-neutral-800 dark:text-white">Progreso</span>
            </div>
            <div class="flex flex-col items-center gap-1">
                <span class="text-4xl" aria-hidden="true">🎓</span>
                <span class="text-sm font-bold text-neutral-800 dark:text-white">Aprende</span>
            </div>
        </div>

        {{-- CTAs --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500 hover:from-yellow-500 hover:via-pink-500 hover:to-purple-600 text-white font-bold py-4 px-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-white/30"
                   wire:navigate>
                    Ir al Dashboard
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500 hover:from-yellow-500 hover:via-pink-500 hover:to-purple-600 text-white font-bold py-4 px-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-white/30"
                   wire:navigate>
                    🎮 Comenzar ahora
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center bg-white/80 dark:bg-neutral-800/80 border-2 border-yellow-300 dark:border-neutral-600 hover:border-pink-400 text-neutral-800 dark:text-white font-semibold py-4 px-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300"
                       wire:navigate>
                        Crear cuenta
                    </a>
                @endif
            @endauth
        </div>
    </div>
</x-layouts.auth>
