<?php

use App\Http\Controllers\AdminAturanController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminGejalaController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminMahasiswaController;
use App\Http\Controllers\AdminPenyakitController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Routes
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/tentang-metode', function () {
    return Inertia::render('TentangMetode');
})->name('tentang-metode');

// Authenticated Student Routes
Route::middleware(['auth'])->group(function () {
    // Redirect dashboard based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.profile');
    })->name('dashboard');

    // Student Profile
    Route::get('/profile', [UserProfileController::class, 'show'])->name('user.profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');

    // Diagnosis Flow
    Route::get('/diagnosa', [DiagnosaController::class, 'create'])->name('diagnosa.create');
    Route::post('/diagnosa', [DiagnosaController::class, 'store'])->name('diagnosa.store');
    Route::get('/hasil/{id}', [DiagnosaController::class, 'show'])->name('diagnosa.show');
    Route::get('/hasil/{id}/print', [DiagnosaController::class, 'print'])->name('diagnosa.print');
    Route::get('/riwayat', [DiagnosaController::class, 'history'])->name('diagnosa.history');
    Route::delete('/riwayat/{id}', [DiagnosaController::class, 'destroy'])->name('diagnosa.destroy');
});

// Authenticated Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Penyakit
    Route::get('/penyakit', [AdminPenyakitController::class, 'index'])->name('penyakit.index');
    Route::post('/penyakit', [AdminPenyakitController::class, 'store'])->name('penyakit.store');
    Route::put('/penyakit/{id}', [AdminPenyakitController::class, 'update'])->name('penyakit.update');
    Route::delete('/penyakit/{id}', [AdminPenyakitController::class, 'destroy'])->name('penyakit.destroy');

    // CRUD Gejala
    Route::get('/gejala', [AdminGejalaController::class, 'index'])->name('gejala.index');
    Route::post('/gejala', [AdminGejalaController::class, 'store'])->name('gejala.store');
    Route::put('/gejala/{id}', [AdminGejalaController::class, 'update'])->name('gejala.update');
    Route::delete('/gejala/{id}', [AdminGejalaController::class, 'destroy'])->name('gejala.destroy');

    // CRUD Aturan
    Route::get('/aturan', [AdminAturanController::class, 'index'])->name('aturan.index');
    Route::post('/aturan', [AdminAturanController::class, 'store'])->name('aturan.store');
    Route::delete('/aturan/{id}', [AdminAturanController::class, 'destroy'])->name('aturan.destroy');

    // Data Mahasiswa
    Route::get('/mahasiswa', [AdminMahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::delete('/mahasiswa/{id}', [AdminMahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

    // Laporan Diagnosa
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/print', [AdminLaporanController::class, 'print'])->name('laporan.print');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
