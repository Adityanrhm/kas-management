<?php

use App\Http\Controllers\CashNominalController;
use App\Http\Controllers\KasSiswaController;
use App\Http\Controllers\ManagementSiswaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/management-siswa', [ManagementSiswaController::class, 'index'])->name('management-siswa')->middleware(['role:admin']);
    Route::post('/management-siswa/store', [ManagementSiswaController::class, 'store_siswa'])->name('store.management-siswa')->middleware('role:admin');
    Route::put('/management-siswa/update/{user_siswa_id}', [ManagementSiswaController::class, 'update_siswa'])->name('update.management-siswa')->middleware('role:admin');
    Route::delete('/management-siswa/delete/{user_id}', [ManagementSiswaController::class, 'destroy_siswa'])->name('destroy.management-siswa')->middleware('role:admin');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/kas-siswa', [KasSiswaController::class, 'index'])->name('kas-siswa')->middleware(['role:siswa']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cash-nominal', [CashNominalController::class, 'index'])->name('cash-nominal')->middleware(['role:admin']);
    Route::get('/cash-nominal/create', [CashNominalController::class, 'store_cash_nominal'])->name('store.cash-nominal')->middleware(['role:admin']);
    Route::get('/cash-nominal/update', [CashNominalController::class, 'update_cash_nominal'])->name('update.cash-nominal')->middleware(['role:admin']);
    Route::get('/cash-nominal/delete/{cash_nominal_id}', [CashNominalController::class, 'destroy.cash_nominal'])->name('delete-cash-nominal')->middleware(['role:admin']);
});

require __DIR__ . '/auth.php';
