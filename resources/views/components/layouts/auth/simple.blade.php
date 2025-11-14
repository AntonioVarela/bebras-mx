<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased overflow-hidden">
        <!-- Fondo colorido y divertido para niños -->
        <div class="fixed inset-0 bg-gradient-to-br from-yellow-400 via-orange-400 via-pink-400 to-purple-500">
            <!-- Estrellas decorativas animadas -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="star star-1">⭐</div>
                <div class="star star-2">✨</div>
                <div class="star star-3">🌟</div>
                <div class="star star-4">⭐</div>
                <div class="star star-5">✨</div>
                <div class="star star-6">🌟</div>
                <div class="star star-7">⭐</div>
                <div class="star star-8">✨</div>
            </div>
            <!-- Formas geométricas flotantes -->
            <div class="absolute top-20 left-10 w-20 h-20 bg-blue-400 rounded-full opacity-60 animate-float" style="animation-delay: 0s;"></div>
            <div class="absolute top-40 right-20 w-16 h-16 bg-green-400 rounded-lg opacity-60 animate-float" style="animation-delay: 1s; transform: rotate(45deg);"></div>
            <div class="absolute bottom-32 left-32 w-24 h-24 bg-red-400 rounded-full opacity-60 animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-20 right-16 w-18 h-18 bg-yellow-300 rounded-lg opacity-60 animate-float" style="animation-delay: 1.5s; transform: rotate(45deg);"></div>
            <!-- Nubes decorativas -->
            <div class="cloud cloud-1">☁️</div>
            <div class="cloud cloud-2">☁️</div>
            <div class="cloud cloud-3">☁️</div>
        </div>

        <!-- Contenido principal -->
        <div class="relative min-h-screen flex items-center justify-center p-6 md:p-10">
            <div class="w-full max-w-md">
                <!-- Logo y título divertido -->
                <div class="text-center mb-8 animate-fade-in">
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-6" wire:navigate>
                        <div class="relative">
                            <div class="absolute inset-0 bg-white rounded-full blur-xl opacity-70 animate-bounce" style="animation-duration: 2s;"></div>
                            <div class="relative bg-white/90 backdrop-blur-md rounded-3xl p-6 border-4 border-yellow-300 shadow-2xl transform hover:scale-110 hover:rotate-3 transition-all duration-300">
                                <x-app-logo-icon class="size-16 fill-current text-purple-600" />
                            </div>
                        </div>
                    </a>
                    <h1 class="text-5xl font-bold mb-2 drop-shadow-2xl" style="background: linear-gradient(45deg, #FF6B6B, #4ECDC4, #FFE66D, #FF6B9D); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        {{ config('app.name', 'Nestbytes Olimpo') }}
                    </h1>
                    <p class="text-white text-lg font-semibold drop-shadow-lg">¡Hola! 👋 ¡Vamos a aprender juntos!</p>
                </div>

                <!-- Card del formulario con estilo divertido -->
                <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border-4 border-yellow-300 p-8 animate-slide-up relative overflow-hidden">
                    <!-- Decoración de esquina -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-300 rounded-bl-full opacity-30"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-pink-300 rounded-tr-full opacity-30"></div>
                    {{ $slot }}
                </div>

                <!-- Footer divertido -->
                <div class="text-center mt-8 animate-fade-in">
                    <p class="text-white text-sm font-semibold drop-shadow-lg">
                        🎉 © {{ date('Y') }} {{ config('app.name', 'Nestbytes Olimpo') }} 🎉
                    </p>
                </div>
            </div>
        </div>

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
            @keyframes float {
                0%, 100% {
                    transform: translateY(0) rotate(0deg);
                }
                50% {
                    transform: translateY(-20px) rotate(5deg);
                }
            }
            @keyframes twinkle {
                0%, 100% {
                    opacity: 0.3;
                    transform: scale(1);
                }
                50% {
                    opacity: 1;
                    transform: scale(1.2);
                }
            }
            @keyframes cloud-float {
                0% {
                    transform: translateX(0);
                }
                100% {
                    transform: translateX(100vw);
                }
            }
            .animate-fade-in {
                animation: fade-in 0.8s ease-out;
            }
            .animate-slide-up {
                animation: slide-up 0.8s ease-out 0.2s both;
            }
            .animate-float {
                animation: float 3s ease-in-out infinite;
            }
            .star {
                position: absolute;
                font-size: 2rem;
                animation: twinkle 2s ease-in-out infinite;
            }
            .star-1 { top: 10%; left: 10%; animation-delay: 0s; }
            .star-2 { top: 20%; right: 15%; animation-delay: 0.5s; }
            .star-3 { top: 40%; left: 5%; animation-delay: 1s; }
            .star-4 { top: 60%; right: 10%; animation-delay: 1.5s; }
            .star-5 { bottom: 30%; left: 20%; animation-delay: 0.3s; }
            .star-6 { bottom: 20%; right: 25%; animation-delay: 0.8s; }
            .star-7 { top: 30%; left: 50%; animation-delay: 1.2s; }
            .star-8 { bottom: 40%; right: 50%; animation-delay: 0.7s; }
            .cloud {
                position: absolute;
                font-size: 4rem;
                opacity: 0.4;
                animation: cloud-float 20s linear infinite;
            }
            .cloud-1 { top: 10%; left: -10%; animation-duration: 25s; }
            .cloud-2 { top: 50%; left: -10%; animation-duration: 30s; animation-delay: 5s; }
            .cloud-3 { bottom: 20%; left: -10%; animation-duration: 35s; animation-delay: 10s; }
        </style>

        @fluxScripts
    </body>
</html>
