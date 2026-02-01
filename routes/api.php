<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/export/compliance', [App\Http\Controllers\ComplianceController::class, 'export'])->name('api.export.compliance');
Route::get('/export/revegetasi', [App\Http\Controllers\RevegetasiController::class, 'export'])->name('api.export.revegetasi');
Route::get('/export/rencana-revegetasi', [App\Http\Controllers\RencanaRevegetasiController::class, 'export'])->name('api.export.rencana-revegetasi');
Route::get('/export/bukaanlahan', [App\Http\Controllers\BukaanLahanController::class, 'export'])->name('api.export.bukaanlahan');
Route::get('/export/rekap-anggaran', [App\Http\Controllers\Admin\RekapAnggaranController::class, 'export'])->name('api.export.rekap-anggaran');
Route::get('/export/alat', [App\Http\Controllers\Admin\EquipmentListController::class, 'export'])->name('api.export.alat');
Route::get('/export/dokumentasi-kegiatan', [App\Http\Controllers\Admin\DokumentasiKegiatanController::class, 'export'])->name('api.export.dokumentasi-kegiatan');
Route::get('/export/document-contract', [App\Http\Controllers\Admin\DocumentContractController::class, 'export'])->name('api.export.rekapanggaran');
Route::get('/export/reklamasi', [App\Http\Controllers\ReklamasiController::class, 'export'])->name('api.export.reklamasi');
Route::get('/export/nursery-monitoring', [App\Http\Controllers\NurseryController::class, 'export'])->name('api.export.nursery');
Route::get('/export/wastewater-monitoring', [App\Http\Controllers\WasteWaterManagementController::class, 'export'])->name('api.export.wastewater');
Route::get('/export/jamkerja', [App\Http\Controllers\Admin\WorkHoursController::class, 'export'])->name('api.export.jamkerja');
Route::get('/export/monitoring-vegetasi', [App\Http\Controllers\MonitoringVegetasiController::class, 'export'])->name('api.export.monitoring-vegetasi');
