<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\Siswa\VoteController;

// Halaman utama (public)
Route::get('/', function () {
    return redirect('/login');
});

// =====================
// 🔐 AUTH ROUTES
// =====================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// =====================
// 🧑 ROLE: SISWA
// =====================

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard/siswa', [SiswaController::class, 'index'])->name('siswa.dashboard');

    // Voting
    Route::get('/vote', [VoteController::class, 'index'])->name('vote.index');
    Route::post('/vote/{vote_item}', [VoteController::class, 'store'])->name('vote.store');
});

// =====================
// 💰 ROLE: BENDAHARA
// =====================

Route::middleware(['auth', 'role:bendahara'])->group(function () {
    Route::get('/dashboard/bendahara', [BendaharaController::class, 'index'])->name('bendahara.dashboard');
});

// =====================
// 🎓 ROLE: GURU
// =====================

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard/guru', [GuruController::class, 'index'])->name('guru.dashboard');
});
