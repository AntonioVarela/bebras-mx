<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Redirigir según rol después del login
Route::get('dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('preguntas.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    // Rutas de Preguntas (id debe ser numérico)
    Route::get('/preguntas', [PreguntaController::class, 'index'])->name('preguntas.index');
    Route::get('/preguntas/{id}', [PreguntaController::class, 'show'])->name('preguntas.show')->where('id', '[0-9]+');
    Route::post('/preguntas/{id}/verificar', [PreguntaController::class, 'verificar'])->name('preguntas.verificar')->where('id', '[0-9]+');

    // Rutas de Admin (solo role admin; ids numéricos)
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/alumno/{id}/progreso', [DashboardController::class, 'verProgreso'])->name('progreso')->where('id', '[0-9]+');
        Route::post('/preguntas/{id}/toggle', [DashboardController::class, 'togglePregunta'])->name('preguntas.toggle')->where('id', '[0-9]+');
    });
});