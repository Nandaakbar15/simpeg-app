<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserPegawaiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/data_pegawai', [PegawaiController::class, 'index']);

    Route::prefix('manajemen_setup')->group(function() {
        Route::get('/instansi_lembaga');
        Route::get('/sekretariat');
        Route::get('/opd_skpd_unitkerja', [UnitKerjaController::class, 'index']);
        Route::get('/view_form_tambah_unitkerja', [UnitKerjaController::class, 'create']);
        Route::post('/opd_skd_unitkerja/tambah_unit_kerja', [UnitKerjaController::class, 'store']);
        Route::get('/data_user_admin', [UserAdminController::class, 'index']);
        Route::get('/view_form_tambah_user_admin', [UserAdminController::class, 'create']);
        Route::post('/tambah_user_admin', [UserAdminController::class, 'store']);
        Route::get('/data_user_pegawai', [UserPegawaiController::class, 'index']);
        Route::get('/view_form_edit_user_admin/{user}', [UserAdminController::class, 'edit']);
        Route::put('/edit_data_user_admin', [UserAdminController::class, 'update']);
    });

    Route::prefix('riwayat_keluarga')->group(function() {
        Route::get('/suami_istri');
        Route::get('/anak');
        Route::get('/orang_tua');
    });

    Route::prefix('riwayat_pendidikan')->group(function() {
        Route::get('/sekolah');
        Route::get('/sekolah_lanjut');
        Route::get('/bahasa');
    });

    Route::prefix('kepegawaian')->group(function() {
        Route::get('/jabatan');
        Route::get('/pangkat');
        Route::get('/hukuman');
        Route::get('/diklat');
        Route::get('/penghargaan');
        Route::get('/penugasanln');
        Route::get('/seminar');
        Route::get('/cuti');
        Route::get('/latihan_jabatan');
        Route::get('/mutasi');
        Route::get('/tunjangan');
        Route::get('/izin_kawin');
    });

});
