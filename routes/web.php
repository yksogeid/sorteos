<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SorteoController;
use App\Http\Controllers\AdminController;

Route::get('/', [SorteoController::class, 'index'])->name('home');
Route::get('/buscar', [SorteoController::class, 'buscar'])->name('buscar');
Route::post('/checkout/iniciar', [SorteoController::class, 'iniciarCheckout'])->name('checkout.iniciar');
Route::post('/checkout/finalizar', [SorteoController::class, 'finalizarCheckout'])->name('checkout.finalizar');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/sorteos/create', [AdminController::class, 'create'])->name('create');
    Route::post('/sorteos', [AdminController::class, 'store'])->name('store');
    Route::get('/sorteos/{sorteo}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/sorteos/{sorteo}', [AdminController::class, 'update'])->name('update');
    Route::delete('/sorteos/{sorteo}', [AdminController::class, 'destroy'])->name('destroy');
});

