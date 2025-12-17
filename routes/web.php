<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Barang\BarangController;

Route::get('/', [AdminController::class, 'index'])->name('dashboard');

// LOGIN
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::middleware(['mustLogin'])->group(function () {

    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');

    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');

    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::get('/barang/export/excel', [BarangController::class, 'exportExcel'])
        ->name('barang.export.excel');

    Route::get('/auth/{id}/edit-password', [AdminController::class, 'editPassword'])
    ->name('admin.editPassword');

    // Proses update password
    Route::post('/auth/{id}/update-password', [AdminController::class, 'updatePassword'])
        ->name('admin.updatePassword');

});

Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
