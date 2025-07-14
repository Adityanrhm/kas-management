<?php

use App\Http\Controllers\MasterSiswaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::middleware(['auth'])->prefix('master')->name('master.')->group(function () {
    Route::get('/siswa', [MasterSiswaController::class, 'index'])->name('siswa');
    Route::post('/siswa/store', [MasterSiswaController::class, 'store_siswa'])->name('store.siswa')->middleware('role:admin');
    Route::put('/siswa/update/{user_siswa_id}', [MasterSiswaController::class, 'update_siswa'])->name('update.siswa')->middleware('role:admin');
    Route::delete('/siswa/{user_id}', [MasterSiswaController::class, 'destroy_siswa'])->name('destroy.siswa')->middleware('role:admin');
});

require __DIR__ . '/auth.php';
