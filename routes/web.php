<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\Bendahara\KasController;
use App\Http\Controllers\Bendahara\VoteItemController;
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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/profil', [AccountController::class, 'profile'])->name('profile');
    Route::patch('/profil', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::get('/pengaturan', [AccountController::class, 'settings'])->name('settings');
    Route::patch('/pengaturan/password', [AccountController::class, 'updatePassword'])->name('settings.password.update');
});

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
    Route::get('/bendahara/transaksi', [BendaharaController::class, 'transactions'])->name('bendahara.transactions');
    Route::get('/bendahara/voting', [BendaharaController::class, 'voting'])->name('bendahara.voting');
    Route::post('/bendahara/kas', [KasController::class, 'store'])->name('bendahara.kas.store');
    Route::post('/bendahara/vote-items', [VoteItemController::class, 'store'])->name('bendahara.vote-items.store');
    Route::patch('/bendahara/vote-items/{voteItem}/reject', [VoteItemController::class, 'reject'])->name('bendahara.vote-items.reject');
});

// =====================
// 🎓 ROLE: GURU
// =====================

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard/guru', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::post('/guru/kelas', [GuruController::class, 'storeClass'])->name('guru.classes.store');
    Route::patch('/guru/users/{target}/kelas', [GuruController::class, 'assignClass'])->name('guru.users.class.update');
    Route::patch('/guru/vote-items/{voteItem}/approve', [GuruController::class, 'approveVote'])->name('guru.vote-items.approve');
});
