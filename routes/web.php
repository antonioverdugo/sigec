<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SponsorController;
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

// Rutas para gestionar los patrocinadores
Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/dashboard/sponsors', [SponsorController::class, 'index'])->name(
    'sponsors.index',
  );
  Route::get('/dashboard/sponsors/create', [
    SponsorController::class,
    'create',
  ])->name('sponsors.create');
  Route::post('/dashboard/sponsors/store', [
    SponsorController::class,
    'store',
  ])->name('sponsors.store');
  Route::get('/dashboard/sponsors/{sponsor}', [
    SponsorController::class,
    'show',
  ])->name('sponsors.show');
  Route::get('/dashboard/sponsors/{sponsor}/edit', [
    SponsorController::class,
    'edit',
  ])->name('sponsors.edit');
  Route::put('/dashboard/sponsors/{sponsor}', [
    SponsorController::class,
    'update',
  ])->name('sponsors.update');
  Route::delete('/dashboard/sponsors/{sponsor}', [
    SponsorController::class,
    'destroy',
  ])->name('sponsors.destroy');
});

// Rutas para gestionar las categorias
Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/dashboard/categories', [
    CategoryController::class,
    'index',
  ])->name('categories.index');
  Route::get('/dashboard/categories/create', [
    CategoryController::class,
    'create',
  ])->name('categories.create');
  Route::post('/dashboard/categories/store', [
    CategoryController::class,
    'store',
  ])->name('categories.store');
  Route::get('/dashboard/categories/{category}', [
    CategoryController::class,
    'show',
  ])->name('categories.show');
  Route::get('/dashboard/categories/{category}/edit', [
    CategoryController::class,
    'edit',
  ])->name('categories.edit');
  Route::put('/dashboard/categories/{category}', [
    CategoryController::class,
    'update',
  ])->name('categories.update');
  Route::delete('/dashboard/categories/{category}', [
    CategoryController::class,
    'destroy',
  ])->name('categories.destroy');
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
