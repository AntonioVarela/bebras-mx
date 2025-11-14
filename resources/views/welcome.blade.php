<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nestbytes Olimpo</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            /* Animaciones personalizadas */
            @keyframes fade-in {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            @keyframes slide-up {
                from { 
                    opacity: 0;
                    transform: translateY(20px);
                }
                to { 
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes blob {
                0%, 100% { transform: translate(0, 0) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            
            @keyframes twinkle {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.3; }
            }
            
            @keyframes cloud-float {
                0% { transform: translateX(0); }
                100% { transform: translateX(100px); }
            }
            
            .animate-fade-in {
                animation: fade-in 0.6s ease-out;
            }
            
            .animate-slide-up {
                animation: slide-up 0.8s ease-out 0.2s both;
            }
            
            .animate-blob {
                animation: blob 7s infinite;
            }
            
            .animate-float {
                animation: float 3s ease-in-out infinite;
            }
            
            .animate-twinkle {
                animation: twinkle 2s ease-in-out infinite;
            }
            
            .animate-cloud-float {
                animation: cloud-float 20s linear infinite;
            }
        </style>
    </head>
    <body class="min-h-screen antialiased relative">
        <!-- Fondo con gradiente animado -->
        <div class="fixed inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-900 dark:via-purple-900 dark:to-pink-900">
            <!-- Patrón de puntos decorativo -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 40px 40px;"></div>
            <!-- Círculos decorativos animados -->
            <div class="absolute top-0 -left-4 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply opacity-30 animate-pulse" style="filter: blur(80px); animation-duration: 8s;"></div>
            <div class="absolute top-0 -right-4 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply opacity-30 animate-pulse" style="filter: blur(80px); animation-duration: 10s; animation-delay: 2s;"></div>
            <div class="absolute -bottom-8 left-20 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply opacity-30 animate-pulse" style="filter: blur(80px); animation-duration: 12s; animation-delay: 4s;"></div>
        </div>

        <!-- Contenido principal -->
        <div class="relative z-10 flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                                class="inline-block px-6 py-2.5 bg-white/20 backdrop-blur-md text-white border-2 border-white/30 hover:bg-white/30 hover:border-white/50 rounded-xl text-sm leading-normal font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-6 py-2.5 bg-white/20 backdrop-blur-md text-white border-2 border-white/30 hover:bg-white/30 hover:border-white/50 rounded-xl text-sm leading-normal font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                        >
                            Iniciar Sesión
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-6 py-2.5 bg-white/20 backdrop-blur-md text-white border-2 border-white/30 hover:bg-white/30 hover:border-white/50 rounded-xl text-sm leading-normal font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                <div class="text-base leading-relaxed flex-1 p-8 pb-12 lg:p-12 backdrop-blur-xl text-neutral-900 dark:text-white shadow-2xl border-4 border-white/50 dark:border-neutral-700/50 rounded-3xl lg:rounded-ss-3xl lg:rounded-ee-none relative overflow-hidden animate-slide-up" style="background: linear-gradient(to bottom right, #fafafa 0%, rgba(199, 210, 254, 0.3) 50%, rgba(233, 213, 255, 0.3) 100%);">
                    <!-- Decoraciones de esquina sutiles -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-bl-full"></div>
                    <div class="absolute bottom-0 left-0 w-28 h-28 bg-gradient-to-tr from-pink-400/20 to-indigo-400/20 rounded-tr-full"></div>
                    
                    <div class="relative z-10">
                        <h1 class="text-4xl lg:text-5xl font-bold mb-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                            ¡Bienvenido a Nestbytes Olimpo! 👋
                        </h1>
                        <p class="mb-8 text-lg lg:text-xl text-neutral-700 dark:text-neutral-300 font-medium leading-relaxed">
                            Desarrolla tu pensamiento computacional resolviendo problemas divertidos y desafiantes. 
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">¡Aprende mientras juegas!</span>
                        </p>
                        
                        <div class="grid gap-4 mb-8">
                            <div class="flex items-start gap-4 p-5 bg-white/60 dark:bg-neutral-800/60 backdrop-blur-sm rounded-2xl border-2 border-indigo-200/50 dark:border-indigo-700/50 hover:border-indigo-400 dark:hover:border-indigo-500 transition-all duration-300 hover:shadow-lg hover:bg-white/80 dark:hover:bg-neutral-800/80">
                                <div class="text-3xl flex-shrink-0">🧩</div>
                                <div>
                                    <h3 class="font-bold text-lg text-neutral-900 dark:text-white mb-1">Resuelve Problemas Divertidos</h3>
                                    <p class="text-neutral-700 dark:text-neutral-300 text-sm leading-relaxed">Desafía tu mente con problemas increíbles de pensamiento computacional diseñados especialmente para ti.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4 p-5 bg-white/60 dark:bg-neutral-800/60 backdrop-blur-sm rounded-2xl border-2 border-purple-200/50 dark:border-purple-700/50 hover:border-purple-400 dark:hover:border-purple-500 transition-all duration-300 hover:shadow-lg hover:bg-white/80 dark:hover:bg-neutral-800/80">
                                <div class="text-3xl flex-shrink-0">🏆</div>
                                <div>
                                    <h3 class="font-bold text-lg text-neutral-900 dark:text-white mb-1">Gana Logros y Progreso</h3>
                                    <p class="text-neutral-700 dark:text-neutral-300 text-sm leading-relaxed">Completa desafíos, mejora tus habilidades y sigue tu progreso paso a paso.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4 p-5 bg-white/60 dark:bg-neutral-800/60 backdrop-blur-sm rounded-2xl border-2 border-pink-200/50 dark:border-pink-700/50 hover:border-pink-400 dark:hover:border-pink-500 transition-all duration-300 hover:shadow-lg hover:bg-white/80 dark:hover:bg-neutral-800/80">
                                <div class="text-3xl flex-shrink-0">🎓</div>
                                <div>
                                    <h3 class="font-bold text-lg text-neutral-900 dark:text-white mb-1">Aprende de Forma Interactiva</h3>
                                    <p class="text-neutral-700 dark:text-neutral-300 text-sm leading-relaxed">Mejora tus habilidades de programación y lógica de manera divertida y práctica.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 px-8 py-4 rounded-xl border-2 border-white/30 text-white text-lg font-bold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 group">
                                <span>🎮 Comenzar ahora</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-white/70 dark:bg-neutral-800/70 backdrop-blur-md hover:bg-white/90 dark:hover:bg-neutral-800/90 border-2 border-white/60 dark:border-neutral-700/60 hover:border-white dark:hover:border-neutral-600 px-8 py-4 rounded-xl text-neutral-800 dark:text-white text-lg font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                    Crear cuenta
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-indigo-100/80 via-purple-100/80 to-pink-100/80 dark:from-indigo-900/50 dark:via-purple-900/50 dark:to-pink-900/50 backdrop-blur-sm relative lg:-ms-px -mb-px lg:mb-0 rounded-t-3xl lg:rounded-t-none lg:rounded-e-3xl aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden border-4 border-white/30 shadow-2xl flex items-center justify-center p-8">
                    {{-- Imagen SVG de niños programando --}}
                    <svg class="w-full h-full max-w-md" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Gradiente definido primero -->
                        <defs>
                            <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#667EEA;stop-opacity:1" />
                                <stop offset="50%" style="stop-color:#764BA2;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#F093FB;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        
                        <!-- Fondo decorativo -->
                        <circle cx="200" cy="200" r="180" fill="url(#gradient1)" opacity="0.3"/>
                        
                        <!-- Niño 1 - Programando -->
                        <g transform="translate(100, 150)">
                            <!-- Cabeza -->
                            <circle cx="50" cy="30" r="25" fill="#FFDBAC"/>
                            <!-- Cuerpo -->
                            <rect x="35" y="55" width="30" height="40" rx="5" fill="#4A90E2"/>
                            <!-- Piernas -->
                            <rect x="38" y="95" width="8" height="25" rx="4" fill="#2C3E50"/>
                            <rect x="54" y="95" width="8" height="25" rx="4" fill="#2C3E50"/>
                            <!-- Laptop -->
                            <rect x="20" y="70" width="50" height="30" rx="3" fill="#34495E"/>
                            <rect x="25" y="75" width="40" height="20" rx="2" fill="#1A1A1A"/>
                            <!-- Código en pantalla -->
                            <line x1="30" y1="80" x2="45" y2="80" stroke="#00FF00" stroke-width="2"/>
                            <line x1="30" y1="85" x2="50" y2="85" stroke="#00FF00" stroke-width="2"/>
                            <line x1="30" y1="90" x2="40" y2="90" stroke="#00FF00" stroke-width="2"/>
                            <!-- Manos -->
                            <circle cx="25" cy="70" r="5" fill="#FFDBAC"/>
                            <circle cx="75" cy="70" r="5" fill="#FFDBAC"/>
                        </g>
                        
                        <!-- Niño 2 - Pensando -->
                        <g transform="translate(250, 180)">
                            <!-- Cabeza -->
                            <circle cx="50" cy="30" r="25" fill="#FFDBAC"/>
                            <!-- Cuerpo -->
                            <rect x="35" y="55" width="30" height="40" rx="5" fill="#E74C3C"/>
                            <!-- Piernas -->
                            <rect x="38" y="95" width="8" height="25" rx="4" fill="#2C3E50"/>
                            <rect x="54" y="95" width="8" height="25" rx="4" fill="#2C3E50"/>
                            <!-- Mano pensando -->
                            <circle cx="75" cy="60" r="8" fill="#FFDBAC"/>
                            <!-- Burbujas de pensamiento -->
                            <circle cx="90" cy="50" r="5" fill="#3498DB" opacity="0.6"/>
                            <circle cx="100" cy="40" r="8" fill="#3498DB" opacity="0.4"/>
                            <circle cx="110" cy="30" r="6" fill="#3498DB" opacity="0.3"/>
                        </g>
                        
                        <!-- Elementos decorativos -->
                        <!-- Estrellas -->
                        <g opacity="0.6">
                            <path d="M50 80 L52 86 L58 86 L53 90 L55 96 L50 92 L45 96 L47 90 L42 86 L48 86 Z" fill="#FFD700"/>
                            <path d="M350 100 L351 103 L354 103 L352 106 L353 109 L350 107 L347 109 L348 106 L346 103 L349 103 Z" fill="#FFD700"/>
                            <path d="M80 320 L81 323 L84 323 L82 326 L83 329 L80 327 L77 329 L78 326 L76 323 L79 323 Z" fill="#FFD700"/>
                        </g>
                        
                        <!-- Código flotante -->
                        <g opacity="0.4">
                            <text x="50" y="250" font-family="monospace" font-size="12" fill="#2C3E50">{ }</text>
                            <text x="320" y="280" font-family="monospace" font-size="12" fill="#2C3E50">&lt;/&gt;</text>
                            <text x="180" y="350" font-family="monospace" font-size="12" fill="#2C3E50">function()</text>
                        </g>
                    </svg>

                    <!-- Decoraciones flotantes adicionales -->
                    <div class="absolute top-8 right-8 text-4xl animate-bounce" style="animation-duration: 2s;">💻</div>
                    <div class="absolute bottom-12 left-8 text-4xl animate-bounce" style="animation-duration: 2.5s; animation-delay: 0.5s;">🚀</div>
                    <div class="absolute inset-0 rounded-t-3xl lg:rounded-t-none lg:rounded-e-3xl"></div>
                </div>
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif

        <style>
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            @keyframes slide-up {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-fade-in {
                animation: fade-in 0.8s ease-out;
            }
            .animate-slide-up {
                animation: slide-up 0.8s ease-out 0.2s both;
            }
        </style>
    </body>
</html>
