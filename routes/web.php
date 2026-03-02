<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\WasteWaterManagementController;
use App\Http\Controllers\RevegetasiController;
use App\Http\Controllers\RencanaRevegetasiController;
use App\Http\Controllers\BukaanLahanController;
use App\Http\Controllers\ReklamasiController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\NurseryController;
use App\Http\Controllers\TrashManagementController;
use App\Http\Controllers\WasteB3MasukController;
use App\Http\Controllers\MonitoringVegetasiController;
use App\Http\Controllers\WasteB3KeluarController;
use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

// Admin
use App\Http\Controllers\Admin\RekapAnggaranController;
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

        // Routing REKAP ANGGARAN
        Route::get('rekap-anggaran', [RekapAnggaranController::class, 'index'])
            ->name('rekap-anggaran');

        // TAMBAH DATA
        Route::get('add-rekap-anggaran', [RekapAnggaranController::class, 'create'])
            ->name('rekap-anggaran.create');

        Route::post('add-contract', [RekapAnggaranController::class, 'store'])
            ->name('rekap-anggaran.store');

        // EDIT DATA
        Route::get('rekap-anggaran/{id}/edit', [RekapAnggaranController::class, 'edit'])
            ->name('rekap-anggaran.edit');

        Route::put('rekap-anggaran/{id}', [RekapAnggaranController::class, 'update'])
            ->name('rekap-anggaran.update');

        // DELETE
        Route::delete('rekap-anggaran/{id}', [RekapAnggaranController::class, 'destroy'])
            ->name('rekap-anggaran.destroy');
        // END ROUTE REKAP ANGGARAN

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

        // USER MANAGEMENT
        // Ini akan menjadi 'admin.user'
        Route::get('user', [App\Http\Controllers\Admin\UserController::class, 'user'])
            ->name('user');

        // Ini akan menjadi 'admin.add-user'
        Route::get('add-user', [App\Http\Controllers\Admin\UserController::class, 'create'])
            ->name('add-user');

        // Ini akan menjadi 'admin.add-user.store'
        Route::post('add-user', [App\Http\Controllers\Admin\UserController::class, 'store'])
            ->name('add-user.store');

        // Ini akan menjadi 'admin.user.edit'
        Route::get('user/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])
            ->name('user.edit');

        // Ini akan menjadi 'admin.user.update'
        Route::put('user/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])
            ->name('user.update');

        // Ini akan menjadi 'admin.user.destroy'
        Route::delete('user/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])
            ->name('user.destroy');
        
    });



Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'index']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    // --- Route Dokumen di sini ---
        Route::get('/documents', [DocumentController::class, 'index'])
            ->name('documents');
        Route::post('/documents/folder', [DocumentController::class, 'storeFolder'])
            ->name('documents.storeFolder');
        Route::post('/documents/upload', [DocumentController::class, 'store'])
            ->name('documents.store');
        Route::put('/documents/{document}/move', [DocumentController::class, 'move'])
            ->name('documents.move');
        Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
            ->name('documents.download');
        Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])
            ->name('documents.preview');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])
            ->name('documents.destroy');
        Route::delete('/folders/{folder}', [DocumentController::class, 'destroyFolder'])
            ->name('documents.destroyFolder');
    // --- END ROUTE DOKUMEN ---

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

    // ROUTING RENCANA REVEGETASI (TARGET BULANAN)
    Route::get('rencana-revegetasi', [RencanaRevegetasiController::class, 'index'])
        ->name('rencana-revegetasi');

    Route::get('rencana-revegetasi/{id}/show', [RencanaRevegetasiController::class, 'show'])
        ->name('rencana-revegetasi.show');

    // TAMBAH DATA RENCANA
    Route::get('rencana-revegetasi/create', [RencanaRevegetasiController::class, 'create'])
        ->name('rencana-revegetasi.create');

    Route::post('rencana-revegetasi', [RencanaRevegetasiController::class, 'store'])
        ->name('rencana-revegetasi.store');

    // EDIT DATA RENCANA
    Route::get('rencana-revegetasi/{id}/edit', [RencanaRevegetasiController::class, 'edit'])
        ->name('rencana-revegetasi.edit');

    Route::put('rencana-revegetasi/{id}', [RencanaRevegetasiController::class, 'update'])
        ->name('rencana-revegetasi.update');

    // DELETE DATA RENCANA
    Route::delete('rencana-revegetasi/{id}', [RencanaRevegetasiController::class, 'destroy'])
        ->name('rencana-revegetasi.destroy');
    // END ROUTING RENCANA REVEGETASI

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

    // ROUTING NURSERY
    Route::get('nursery', [NurseryController::class, 'index'])
        ->name('nursery');

    // ADD DATA
    Route::get('nursery/create', [NurseryController::class, 'create'])
        ->name('nursery.create');

    Route::post('nursery', [NurseryController::class, 'store'])
        ->name('nursery.store');

    // EDIT DATA
    Route::get('nursery/{id}/edit', [NurseryController::class, 'edit'])
        ->name('nursery.edit');

    Route::put('nursery/{id}', [NurseryController::class, 'update'])
        ->name('nursery.update');

    // DELETE DATA
    Route::delete('nursery/{id}', [NurseryController::class, 'destroy'])
        ->name('nursery.destroy');
    // END NURSERY

    // ROUTING compliance
    Route::get('compliance', [ComplianceController::class, 'index'])
        ->name('compliance');

    // CREATE
    Route::get('compliance/create', [ComplianceController::class, 'create'])
        ->name('compliance.create');

    Route::post('compliance', [ComplianceController::class, 'store'])
        ->name('compliance.store');

    // EDIT
    Route::get('compliance/{id}/edit', [ComplianceController::class, 'edit'])
        ->name('compliance.edit');

    Route::put('compliance/{id}', [ComplianceController::class, 'update'])
        ->name('compliance.update');

    // DELETE
    Route::delete('compliance/{id}', [ComplianceController::class, 'destroy'])
        ->name('compliance.destroy');
    // END compliance

    // ROUTING TRASH MANAGEMENT 
    Route::get('trash-management', [TrashManagementController::class, 'index'])
        ->name('trash-management');

    // CREATE
    Route::get('trash-management/create', [TrashManagementController::class, 'create'])
        ->name('trash-management.create');

    Route::post('trash-management', [TrashManagementController::class, 'store'])
        ->name('trash-management.store');

    // EDIT
    Route::get('trash-management/{id}/edit', [TrashManagementController::class, 'edit'])
        ->name('trash-management.edit');

    Route::put('trash-management/{id}', [TrashManagementController::class, 'update'])
        ->name('trash-management.update');

    // DELETE
    Route::delete('trash-management/{id}', [TrashManagementController::class, 'destroy'])
        ->name('trash-management.destroy');
    // END TRASH MANAGEMENT

    // ROUTING LIMBAH B3
    Route::get('waste-b3', [WasteB3MasukController::class, 'index'])
        ->name('waste-b3');

    // CREATE
    Route::get('waste-b3/create', [WasteB3MasukController::class, 'create'])
        ->name('waste-b3.create');

    Route::post('waste-b3', [WasteB3MasukController::class, 'store'])
        ->name('waste-b3.store');

    // EDIT
    Route::get('waste-b3/{id}/edit', [WasteB3MasukController::class, 'edit'])
        ->name('waste-b3.edit');

    Route::put('waste-b3/{id}', [WasteB3MasukController::class, 'update'])
        ->name('waste-b3.update');

    // DELETE
    Route::delete('waste-b3/{id}', [WasteB3MasukController::class, 'destroy'])
        ->name('waste-b3.destroy');
    // END LIMBAH B3

    // ROUTING MONITORING VEGETASI
    Route::get('monitoring-vegetasi', [MonitoringVegetasiController::class, 'index'])
        ->name('monitoring-vegetasi');

    // CREATE
    Route::get('monitoring-vegetasi/create', [MonitoringVegetasiController::class, 'create'])
        ->name('monitoring-vegetasi.create');

    Route::post('monitoring-vegetasi', [MonitoringVegetasiController::class, 'store'])
        ->name('monitoring-vegetasi.store');

    // EDIT
    Route::get('monitoring-vegetasi/{id}/edit', [MonitoringVegetasiController::class, 'edit'])
        ->name('monitoring-vegetasi.edit');

    Route::put('monitoring-vegetasi/{id}', [MonitoringVegetasiController::class, 'update'])
        ->name('monitoring-vegetasi.update');

    // DELETE
    Route::delete('monitoring-vegetasi/{id}', [MonitoringVegetasiController::class, 'destroy'])
        ->name('monitoring-vegetasi.destroy');
    // END MONITORING VEGETASI

    // ROUTING WASTE B3 KELUAR
    Route::get('waste-b3-keluar', [WasteB3KeluarController::class, 'index'])
        ->name('waste-b3-keluar');

    Route::get('waste-b3-keluar/create', [WasteB3KeluarController::class, 'create'])
        ->name('waste-b3-keluar.create');

    Route::get('waste-b3-keluar/create1', [WasteB3KeluarController::class, 'create1'])
        ->name('waste-b3-keluar.create1');

    Route::post('waste-b3-keluar', [WasteB3KeluarController::class, 'store'])
        ->name('waste-b3-keluar.store');

    Route::get('waste-b3-keluar/{id}', [WasteB3KeluarController::class, 'show'])
        ->name('waste-b3-keluar.show');

    Route::get('waste-b3-keluar/{id}/download', [WasteB3KeluarController::class, 'downloadDokumen'])
        ->name('waste-b3-keluar.download');

    Route::get('waste-b3-keluar/{id}/edit', [WasteB3KeluarController::class, 'edit'])
        ->name('waste-b3-keluar.edit');

    Route::put('waste-b3-keluar/{id}', [WasteB3KeluarController::class, 'update'])
        ->name('waste-b3-keluar.update');

    Route::delete('waste-b3-keluar/{id}', [WasteB3KeluarController::class, 'destroy'])
        ->name('waste-b3-keluar.destroy');

   Route::post('/logout', [SessionsController::class, 'destroy'])->name('logout');
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    // Cukup satu rute GET untuk login, arahkan ke Controller
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});