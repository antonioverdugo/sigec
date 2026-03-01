<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tools\DashboardController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

// Ruta de inicio
Route::get('/', function () {
  return view('auth.login');
})->name('home');

// Ruta donde llegan todos los usuarios
Route::get('/dashboard', [DashboardController::class, 'index'])
  ->middleware(['auth', 'verified'])
  ->name('dashboard');

// Rutas para gestionar los usuarios
Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/dashboard/users', [UsersController::class, 'index'])->name(
    'users.index',
  );
  Route::get('/dashboard/users/create', [
    UsersController::class,
    'create',
  ])->name('users.create');
  Route::post('/dashboard/users/store', [
    UsersController::class,
    'store',
  ])->name('users.store');
  Route::get('/dashboard/users/{user}', [UsersController::class, 'show'])->name(
    'users.show',
  );
  Route::get('/dashboard/users/{user}/edit', [
    UsersController::class,
    'edit',
  ])->name('users.edit');
  Route::put('/dashboard/users/{user}', [
    UsersController::class,
    'update',
  ])->name('users.update');
  Route::delete('/dashboard/users/{user}', [
    UsersController::class,
    'destroy',
  ])->name('users.destroy');
});

// Rutas para cambiar los datos del perfil de usuario
Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name(
    'profile.edit',
  );
  Route::patch('/profile', [ProfileController::class, 'update'])->name(
    'profile.update',
  );
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name(
    'profile.destroy',
  );
});

require __DIR__ . '/auth.php';
