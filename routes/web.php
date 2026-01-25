<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\WasteWaterManagementController;
use App\Http\Controllers\RevegetasiController;
use App\Http\Controllers\BukaanLahanController;
use App\Http\Controllers\ReklamasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

// Admin
use App\Http\Controllers\Admin\DocumentContractController;
use App\Http\Controllers\Admin\EquipmentListController;
use App\Http\Controllers\Admin\WorkHoursController;
use App\Http\Controllers\Admin\DokumentasiKegiatanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard ', [HomeController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Routing Document Contract
        Route::get('document-contract', [DocumentContractController::class, 'index'])
            ->name('document-contract');

        // TAMBAH DATA
        Route::get('add-contract', [DocumentContractController::class, 'create'])
            ->name('document-contract.create');

        Route::post('add-contract', [DocumentContractController::class, 'store'])
            ->name('document-contract.store');

        // EDIT DATA
        Route::get('document-contract/{id}/edit', [DocumentContractController::class, 'edit'])
            ->name('document-contract.edit');

        Route::put('document-contract/{id}', [DocumentContractController::class, 'update'])
            ->name('document-contract.update');

        // DELETE
        Route::delete('document-contract/{id}', [DocumentContractController::class, 'destroy'])
            ->name('document-contract.destroy');
        // END ROUTE DOCUMENT CONTRACT

        // ROUTING EQUIPMENT LIST
        Route::get('equipment-list', [EquipmentListController::class, 'index'])
            ->name('equipment-list');
        
        // TAMBAH DATA EQUIPMENT
        Route::get('add-equipment', [EquipmentListController::class, 'create'])
            ->name('equipment-list.create');

        Route::post('add-equipment', [EquipmentListController::class, 'store'])
            ->name('equipment-list.store');

        // EDIT & UPDATE
        Route::get('equipment-list/{id}/edit', [EquipmentListController::class, 'edit'])
            ->name('equipment-list.edit');

        Route::put('equipment-list/{id}', [EquipmentListController::class, 'update'])
            ->name('equipment-list.update');

        // DELETE (opsional)
        Route::delete('equipment-list/{id}', [EquipmentListController::class, 'destroy'])
            ->name('equipment-list.destroy');
        // END EQUIPMENT LIST
        
        // ROUTING WORK-HOURS
        Route::get('work-hours', [WorkHoursController::class, 'index'])
            ->name('work-hours');
        
        // TAMBAH DATA WORK HOURS
        Route::get('add-work-hour', [WorkHoursController::class, 'create'])
            ->name('work-hours.create');

        Route::post('add-work-hour', [WorkHoursController::class, 'store'])
            ->name('work-hours.store');

        // EDIT DATA
        Route::get('work-hours/{id}/edit', [WorkHoursController::class, 'edit'])
            ->name('work-hours.edit');

        Route::put('work-hours/{id}', [WorkHoursController::class, 'update'])
            ->name('work-hours.update');

        // DELETE
        Route::delete('work-hours/{id}', [WorkHoursController::class, 'destroy'])
            ->name('work-hours.destroy');

        // ROUTING DOKUMENTASI KEGIATAN
        Route::get('dokumentasi-kegiatan', [DokumentasiKegiatanController::class, 'index'])
            ->name('dokumentasi-kegiatan');

        // Gallery
        Route::get('dokumentasi-kegiatan/gallery', [DokumentasiKegiatanController::class, 'gallery'])
            ->name('dokumentasi-kegiatan.gallery');

        // CREATE
        Route::get('dokumentasi-kegiatan/create', [DokumentasiKegiatanController::class, 'create'])
            ->name('dokumentasi-kegiatan.create');

        Route::post('dokumentasi-kegiatan', [DokumentasiKegiatanController::class, 'store'])
            ->name('dokumentasi-kegiatan.store');

        // EDIT
        Route::get('dokumentasi-kegiatan/{id}/edit', [DokumentasiKegiatanController::class, 'edit'])
            ->name('dokumentasi-kegiatan.edit');

        Route::put('dokumentasi-kegiatan/{id}', [DokumentasiKegiatanController::class, 'update'])
            ->name('dokumentasi-kegiatan.update');

        // DELETE
        Route::delete('dokumentasi-kegiatan/{id}', [DokumentasiKegiatanController::class, 'destroy'])
            ->name('dokumentasi-kegiatan.destroy');
    });



Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    // ROUTING WASTE WATER MANAGEMENT
    Route::get('waste-water-management', [WasteWaterManagementController::class, 'index'])
        ->name('waste-water-management');

    // ADD DATA
    Route::get('waste-water-management/create', [WasteWaterManagementController::class, 'create'])
        ->name('waste-water-management.create');

    Route::post('waste-water-management', [WasteWaterManagementController::class, 'store'])
        ->name('waste-water-management.store');

    // EDIT DATA
    Route::get('waste-water-management/{id}/edit', [WasteWaterManagementController::class, 'edit'])
        ->name('waste-water-management.edit');

    Route::put('waste-water-management/{id}', [WasteWaterManagementController::class, 'update'])
        ->name('waste-water-management.update');

    // DELETE DATA
    Route::delete('waste-water-management/{id}', [WasteWaterManagementController::class, 'destroy'])
        ->name('waste-water-management.destroy');
    // END ROUTING WASTE WATER MANAGEMENT

    // ROUTING REVEGETASI
    Route::get('revegetasi', [RevegetasiController::class, 'index'])
        ->name('revegetasi');

    // ADD DATA
    Route::get('revegetasi/create', [RevegetasiController::class, 'create'])
        ->name('revegetasi.create');

    Route::post('revegetasi', [RevegetasiController::class, 'store'])
        ->name('revegetasi.store');

    // EDIT DATA
    Route::get('revegetasi/{id}/edit', [RevegetasiController::class, 'edit'])
        ->name('revegetasi.edit');

    Route::put('revegetasi/{id}', [RevegetasiController::class, 'update'])
        ->name('revegetasi.update');

    // DELETE DATA
    Route::delete('revegetasi/{id}', [RevegetasiController::class, 'destroy'])
        ->name('revegetasi.destroy');
    // END ROUTING REVEGETASI

    // ROUTING BUKAAN LAHAN
    Route::get('bukaan-lahan', [BukaanLahanController::class, 'index'])
        ->name('bukaan-lahan');

    // ADD DATA
    Route::get('bukaan-lahan/create', [BukaanLahanController::class, 'create'])
        ->name('bukaan-lahan.create');

    Route::post('bukaan-lahan', [BukaanLahanController::class, 'store'])
        ->name('bukaan-lahan.store');

    // EDIT DATA
    Route::get('bukaan-lahan/{id}/edit', [BukaanLahanController::class, 'edit'])
        ->name('bukaan-lahan.edit');

    Route::put('bukaan-lahan/{id}', [BukaanLahanController::class, 'update'])
        ->name('bukaan-lahan.update');

    // DELETE DATA
    Route::delete('bukaan-lahan/{id}', [BukaanLahanController::class, 'destroy'])
        ->name('bukaan-lahan.destroy');
    // END BUKAAN LAHAN

    // ROUTING REKLAMASI
    Route::get('reklamasi', [ReklamasiController::class, 'index'])
        ->name('reklamasi');

    // ADD DATA
    Route::get('reklamasi/create', [ReklamasiController::class, 'create'])
        ->name('reklamasi.create');

    Route::post('reklamasi', [ReklamasiController::class, 'store'])
        ->name('reklamasi.store');

    // EDIT DATA
    Route::get('reklamasi/{id}/edit', [ReklamasiController::class, 'edit'])
        ->name('reklamasi.edit');

    Route::put('reklamasi/{id}', [ReklamasiController::class, 'update'])
        ->name('reklamasi.update');

    // DELETE DATA
    Route::delete('reklamasi/{id}', [ReklamasiController::class, 'destroy'])
        ->name('reklamasi.destroy');
    // END REKLAMASI

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');