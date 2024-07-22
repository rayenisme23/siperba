<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanbakuController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Permintaan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::middleware('guest')->group(function () {
    // Template
    // Route::view('/table-datatable', 'table-datatable');
    // Route::view('/table-basic-table', 'table-basic-table');
    // Route::view('/component-modals', 'component-modals');
    // Route::view('/icons-boxicons', 'icons-boxicons');
    // Route::view('/form-input-group', 'form-input-group');
    // Route::view('/icons-boxicons', 'icons-boxicons');
    // Route::view('/user-profile', 'user-profile');

    Route::view('/', 'auth.login');

    // Register
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost']);
});

Route::middleware('auth',)->group(function () {
    // Dahsboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/user/profile', [HomeController::class, 'profile']);
    Route::post('/profile-edit', [ProfileController::class, 'edit']);

    // User
    Route::get('/master/user', [UserController::class, 'index'])->middleware('role:Administrator');
    Route::post('/user-add', [UserController::class, 'store'])->middleware('role:Administrator');
    Route::post('/user-edit', [UserController::class, 'edit'])->middleware('role:Administrator');
    Route::post('/user-destroy', [UserController::class, 'destroy'])->middleware('role:Administrator');

    // Bahanbaku
    Route::get('/master/bahanbaku', [BahanbakuController::class, 'index'])->middleware('role:Administrator|Pembelian|Gudang');
    Route::post('/bahanbaku-add', [BahanbakuController::class, 'store'])->middleware('role:Administrator|Pembelian|Gudang');
    Route::post('/bahanbaku-edit', [BahanbakuController::class, 'edit'])->middleware('role:Administrator|Pembelian|Gudang');
    Route::post('/bahanbaku-destroy', [BahanbakuController::class, 'destroy'])->middleware('role:Administrator|Pembelian|Gudang');

    // Departemen
    Route::get('/master/departemen', [DepartemenController::class, 'index'])->middleware('role:Administrator');
    Route::post('/departemen-store', [DepartemenController::class, 'store'])->middleware('role:Administrator');
    Route::post('/departemen-edit', [DepartemenController::class, 'edit'])->middleware('role:Administrator');
    Route::post('/departemen-destroy', [DepartemenController::class, 'destroy'])->middleware('role:Administrator');

    // Supplier
    Route::get('/master/supplier', [SupplierController::class, 'index'])->middleware('role:Administrator|Pembelian');
    Route::post('/supplier-store', [SupplierController::class, 'store'])->middleware('role:Administrator|Pembelian');
    Route::post('/supplier-edit', [SupplierController::class, 'edit'])->middleware('role:Administrator|Pembelian');
    Route::post('/supplier-destroy', [SupplierController::class, 'destroy'])->middleware('role:Administrator|Pembelian');

    // Permintaan
    Route::get('/manajemen/permintaan', [PermintaanController::class, 'index'])->middleware('role:Produksi|Gudang');
    Route::post('/permintaan-store', [PermintaanController::class, 'store'])->middleware('role:Produksi');
    Route::post('/permintaan-edit', [PermintaanController::class, 'edit'])->middleware('role:Produksi|Gudang');
    Route::post('/permintaan-destroy', [PermintaanController::class, 'destroy'])->middleware('role:Produksi');
    Route::get('/user-get/{id}', [PermintaanController::class, 'user'])->middleware('role:Gudang');
    Route::get('/bahanbaku-get/{id}', [PermintaanController::class, 'bahanbaku'])->middleware('role:Gudang');
    Route::get('/departemen-get/{id}', [PermintaanController::class, 'departemen'])->middleware('role:Gudang');
    // Permintaan-detail
    Route::get('/permintaan-detail', [PermintaanController::class, 'detail'])->middleware('role:Gudang');
    Route::post('/permintaan-terima', [PermintaanController::class, 'terimastatus'])->middleware('role:Gudang');
    Route::post('/permintaan-tolak', [PermintaanController::class, 'tolakstatus'])->middleware('role:Gudang');

    // Pembelian
    Route::get('/manajemen/pembelian', [PembelianController::class, 'index'])->middleware('role:Pembelian|Gudang');
    Route::post('/pembelian-store', [PembelianController::class, 'store'])->middleware('role:Pembelian');
    Route::post('/pembelian-edit', [PembelianController::class, 'edit'])->middleware('role:Pembelian');
    Route::get('/pembelian-bb/{id}', [PembelianController::class, 'bahanBaku'])->middleware('role:Pembelian|Gudang');
    Route::get('/pembelian-supp/{id}', [PembelianController::class, 'supplier'])->middleware('role:Pembelian|Gudang');
    Route::post('/pembelian-destroy', [PembelianController::class, 'destroy'])->middleware('role:Pembelian');
    Route::post('/pembelian-simpan', [PembelianController::class, 'simpan'])->middleware('role:Pembelian|Gudang');
    Route::post('/pembelian/hapus-bahanbaku', [PembelianController::class, 'hapusBahanbaku'])->middleware('role:Pembelian');
    Route::post('/pembelian/tambah-bahanbaku', [PembelianController::class, 'tambahBahanbaku'])->middleware('role:Pembelian');

    // Permintaan-detail
    Route::get('/pembelian-detail', [PembelianController::class, 'detail'])->middleware('role:Gudang');
    Route::post('/pembelian-terima', [PembelianController::class, 'terimastatus'])->middleware('role:Gudang');

    // Laporan
    Route::get('/laporan/pembelian', [LaporanController::class, 'pembelian'])->middleware('role:Administrator|Gudang|Pembelian');
    Route::get('/laporan/permintaan', [LaporanController::class, 'permintaan'])->middleware('role:Administrator|Gudang|Permintaan');
});
