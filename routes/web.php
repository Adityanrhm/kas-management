<?php

use App\Http\Controllers\MasterGuruController;
use App\Http\Controllers\MasterSiswaController;
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

Route::get('/siswa', [MasterSiswaController::class, 'index'])->name('master.siswa');
Route::get('/guru', [MasterGuruController::class, 'index'])->name('master.guru');

require __DIR__ . '/auth.php';
