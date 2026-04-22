<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RiwayatKeluargaAnakController;
use App\Http\Controllers\RiwayatKeluargaSuamiIstriController;
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

    Route::prefix('data_pegawai')->group(function() {
        Route::get('/pegawai', [PegawaiController::class, 'index']);
        Route::get('/view_form_tambah_data_pegawai', [PegawaiController::class, 'create']);
        Route::post('/tambah_data_pegawai', [PegawaiController::class, 'store']);
        Route::get('/view_form_edit_data_pegawai/{pegawai}', [PegawaiController::class, 'edit']);
        Route::put('/ubah_data_pegawai/{pegawai}', [PegawaiController::class, 'update']);
        Route::delete('/delete_data_pegawai/{pegawai}', [PegawaiController::class, 'destroy']);
    });

    Route::prefix('manajemen_setup')->group(function() {
        Route::get('/instansi_lembaga');
        Route::get('/sekretariat');
        Route::get('/opd_skpd_unitkerja', [UnitKerjaController::class, 'index']);
        Route::get('/view_form_tambah_unitkerja', [UnitKerjaController::class, 'create']);
        Route::post('/opd_skd_unitkerja/tambah_unit_kerja', [UnitKerjaController::class, 'store']);

        // URL buat data user admin
        Route::get('/data_user_admin', [UserAdminController::class, 'index']);
        Route::get('/view_form_tambah_user_admin', [UserAdminController::class, 'create']);
        Route::post('/tambah_user_admin', [UserAdminController::class, 'store']);
        Route::get('/data_user_pegawai', [UserPegawaiController::class, 'index']);
        Route::get('/view_form_edit_user_admin/{user}', [UserAdminController::class, 'edit']);
        Route::put('/edit_data_user_admin', [UserAdminController::class, 'update']);

        // URL buat data user pegawai
        Route::get('/data_user_pegawai', [UserPegawaiController::class, 'index']);
        Route::get('/view_form_tambah_user_pegawai', [UserPegawaiController::class, 'create']);
        Route::get('/view_form_edit_user_pegawai/{user}', [UserPegawaiController::class, 'edit']);
        Route::post('/tambah_user_pegawai', [UserPegawaiController::class, 'store']);
        Route::put('/edit_data_user_pegawai', [UserPegawaiController::class, 'update']);
    });

    Route::prefix('riwayat_keluarga')->group(function() {
        // URL Riwayat Keluarga Suami / Istri Pegawai
        Route::get('/suami_istri', [RiwayatKeluargaSuamiIstriController::class, 'index']);
        Route::get('/suami_istri/view_form_tambah_suami_istri', [RiwayatKeluargaSuamiIstriController::class, 'create']);
        Route::post('/suami_istri/tambah_data_suami_istri', [RiwayatKeluargaSuamiIstriController::class, 'store']);
        Route::get('/suami_istri/view_edit_data_suami_istri/{riwayatKeluargaSuamiIstri}', [RiwayatKeluargaSuamiIstriController::class, 'edit']);
        Route::put('/suami_istri/edit_keluarga_istri', [RiwayatKeluargaSuamiIstriController::class, 'update']);

        // URL Riwayat Keluarga Anak Pegawai
        Route::get('/anak', [RiwayatKeluargaAnakController::class, 'index']);
        Route::get('/anak/view_tambah_data_anak', [RiwayatKeluargaAnakController::class, 'create']);
        Route::post('/anak/tambah_data_anak', [RiwayatKeluargaAnakController::class, 'store']);
        Route::get('/anak/view_edit_data_anak/{riwayatKeluargaAnak}', [RiwayatKeluargaAnakController::class, 'edit']);
        Route::put('/anak/edit_data_anak/{riwayatKeluargaAnak}', [RiwayatKeluargaAnakController::class, 'update']);

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
