<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanbakuController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
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

    Route::view('/', ('auth.login'));

    // Register
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost']);
});

Route::middleware('auth')->group(function () {
    // Dahsboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // User
    Route::get('/master/user', [UserController::class, 'index']);
    Route::post('/user-add', [UserController::class, 'store']);
    Route::post('/user-edit', [UserController::class, 'edit']);
    Route::post('/user-destroy', [UserController::class, 'destroy']);

    // Bahanbaku
    Route::get('/master/bahanbaku', [BahanbakuController::class, 'index']);
    Route::post('/bahanbaku-add', [BahanbakuController::class, 'store']);
    Route::post('/bahanbaku-edit', [BahanbakuController::class, 'edit']);
    Route::post('/bahanbaku-destroy', [BahanbakuController::class, 'destroy']);

    // Departemen
    Route::get('/master/departemen', [DepartemenController::class, 'index']);
    Route::post('/departemen-store', [DepartemenController::class, 'store']);
    Route::post('/departemen-edit', [DepartemenController::class, 'edit']);
    Route::post('/departemen-destroy', [DepartemenController::class, 'destroy']);

    // Supplier
    Route::get('/master/supplier', [SupplierController::class, 'index']);
    Route::post('/supplier-store', [SupplierController::class, 'store']);
    Route::post('/supplier-edit', [SupplierController::class, 'edit']);
    Route::post('/supplier-destroy', [SupplierController::class, 'destroy']);

    // Permintaan
    Route::get('/manajemen/permintaan', [PermintaanController::class, 'index']);
    Route::post('/permintaan-store', [PermintaanController::class, 'store']);
    Route::post('/permintaan-edit', [PermintaanController::class, 'edit']);
    Route::post('/permintaan-destroy', [PermintaanController::class, 'destroy']);


    // // Pembelian
    // Route::get('/manajemen/pembelian', [PembelianController::class, 'index']);
    // Route::post('/pembelian-store', [PembelianController::class, 'store']);
    // Route::post('/pembelian-edit', [PembelianController::class, 'edit']);
    // Route::post('/pembelian-detail', [PembelianController::class, 'detail']);
    // Route::post('/pembelian-destroy', [PembelianController::class, 'destroy']);
    // Route::get('/pembelian-bb/{id}', [PembelianController::class, 'getBahanbaku']);

    // Pembelian
    Route::get('/pembelian/create', [PembelianController::class, 'create']);
    Route::get('/manajemen/pembelian', [PembelianController::class, 'index']);
    Route::post('/pembelian-store', [PembelianController::class, 'store']);
    Route::post('/pembelian-edit', [PembelianController::class, 'edit']);
    Route::get('/pembelian-bb/{id}', [PembelianController::class, 'bahanBaku']);
    Route::get('/pembelian-supp/{id}', [PembelianController::class, 'supplier']);
    Route::post('/pembelian-destroy', [PembelianController::class, 'destroy']);
    Route::post('/pembelian-simpan', [PembelianController::class, 'simpan']);
    Route::post('/pembelian-detail', [PembelianController::class, 'detail']);

    // Detail
    Route::get('/detail', [PembelianController::class, 'detail']);
});
