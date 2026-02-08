<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SorteoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', [SorteoController::class, 'index'])->name('home');
Route::get('/sorteo/{sorteo}', [SorteoController::class, 'show'])->name('sorteo.show');
Route::get('/buscar', [SorteoController::class, 'buscar'])->name('buscar');
Route::post('/checkout/iniciar', [SorteoController::class, 'iniciarCheckout'])->name('checkout.iniciar');
Route::post('/checkout/finalizar', [SorteoController::class, 'finalizarCheckout'])->name('checkout.finalizar');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/sorteos/create', [AdminController::class, 'create'])->name('create');
    Route::post('/sorteos', [AdminController::class, 'store'])->name('store');
    Route::get('/sorteos/{sorteo}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/sorteos/{sorteo}', [AdminController::class, 'update'])->name('update');
    Route::delete('/sorteos/{sorteo}', [AdminController::class, 'destroy'])->name('destroy');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

    // Tickets search
    Route::get('/sorteos/{sorteo}/tickets/search', [AdminController::class, 'searchTickets'])->name('tickets.search');
});

