<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManajemenController;
use App\Http\Controllers\IzinSiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\AjukanIzinController;
use App\Http\Controllers\ProfileController;

// ==========================
// PUBLIC ROUTES
// ==========================

Route::get('/', fn () => view('welcome'))->name('welcome');

Route::middleware(['isLogin'])->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProses'])->name('loginProses');

    // Register
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProses'])->name('registerProses');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password
Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('forgot');
Route::post('/forgot-password', [AuthController::class, 'forgotProses'])->name('forgotProses');

// Reset Password - tampilkan form dari link email
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])
    ->middleware('guest')
    ->name('password.reset');

// Reset Password - proses update password
Route::post('/reset-password', [AuthController::class, 'resetPasswordProses'])
    ->middleware('guest')
    ->name('password.update');
    
// ==========================
// PROTECTED ROUTES (Login Required)
// ==========================

Route::middleware(['auth', 'checkLogin'])->group(function () {

    // DASHBOARD (SEMUA USER)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
     
    // ADMIN ROUTES
    Route::middleware(['isAdmin'])->group(function () {

        // Manajemen User
        Route::prefix('admin/manajemenuser')->name('manajemenuser.')->group(function () {
            Route::get('manajemen', [ManajemenController::class, 'manajemen'])->name('manajemen');
            Route::get('create', [ManajemenController::class, 'create'])->name('create');
            Route::post('store', [ManajemenController::class, 'store'])->name('store');
            Route::get('edit/{id}', [ManajemenController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [ManajemenController::class, 'update'])->name('update');
            Route::delete('destroy/{id}', [ManajemenController::class, 'destroy'])->name('destroy');
        });

        // Export
        Route::get('/manajemen/export/excel', [ManajemenController::class, 'exportExcel'])->name('manajemen.export.excel');
        Route::get('/manajemen/export/pdf', [ManajemenController::class, 'exportPdf'])->name('manajemen.export.pdf');

        // Data izin siswa (khusus Admin)
        Route::get('/admin/data-izin', [AjukanIzinController::class, 'indexAdmin'])->name('izin.admin');
        Route::patch('/admin/data-izin/{id}/status', [AjukanIzinController::class, 'updateStatus'])->name('izin.updateStatus');

        // Menu Izin Siswa (khusus Admin)
        Route::get('/izin-siswa', [IzinSiswaController::class, 'index'])->name('izinsiswa');
        Route::get('/izin-siswa/{id}/download', [IzinSiswaController::class, 'download'])->name('izin.download');
        Route::patch('/izin-siswa/{id}/catatan', [IzinSiswaController::class, 'updateCatatan'])->name('izin.updateCatatan');
        Route::delete('izin-siswa/{id}', [IzinSiswaController::class, 'destroy'])->name('izin.destroy');

        // Export data izin siswa
        Route::get('/izin/export/excel', [IzinSiswaController::class, 'exportExcel'])->name('dataizinExcel');
        Route::get('/izin/export/pdf', [IzinSiswaController::class, 'exportpdf'])->name('dataizinPdf');

        // ADMIN
        Route::prefix('admin/kalender')->name('admin.kalender.')->group(function () {
            Route::get('/', [KalenderController::class, 'index'])->name('index');
            Route::post('/catatan', [KalenderController::class, 'storeCatatan'])->name('store');
            Route::put('/catatan/{id}', [KalenderController::class, 'update'])->name('update');
            Route::delete('/{id}', [KalenderController::class, 'destroy'])->name('destroy');
        });   
        
        // Hapus riwayat izin dari dashboard admin
        Route::delete('/admin/riwayat-izin/{id}', [DashboardController::class, 'hapusRiwayatAdmin'])
            ->name('admin.riwayat.hapus');

    });

    // ==========================
    // SISWA ROUTES
    // ==========================
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('ajukan', [AjukanIzinController::class, 'index'])->name('ajukan');
        Route::get('ajukan-izin', [AjukanIzinController::class, 'create'])->name('ajukan-izin.form');
        Route::post('ajukan-izin', [AjukanIzinController::class, 'store'])->name('ajukan-izin.store');
        Route::get('edit/{id}', [AjukanIzinController::class, 'edit'])->name('edit'); 
        Route::put('update/{id}', [AjukanIzinController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [AjukanIzinController::class, 'destroy'])->name('destroy'); 
        Route::get('/izin/export/pdf', [AjukanIzinController::class, 'exportpdf'])->name('ajukanizinPdf');   
    
        // Kalender khusus siswa
        Route::prefix('kalender')->name('kalender.')->group(function () {
            Route::get('/', [KalenderController::class, 'index'])->name('index');
            Route::post('/catatan', [KalenderController::class, 'storeCatatan'])->name('store');
            Route::put('/catatan/{id}', [KalenderController::class, 'update'])->name('update');
            Route::delete('/catatan/{id}', [KalenderController::class, 'destroy'])->name('destroy');
        });  
        
        Route::middleware(['auth', 'checkLogin:Siswa'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
            // 🔽 Tambahkan route hapus riwayat di sini
            Route::delete('/riwayat-izin/{id}', [DashboardController::class, 'hapusRiwayat'])
                ->name('riwayat.hapus');
        });
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto');
});