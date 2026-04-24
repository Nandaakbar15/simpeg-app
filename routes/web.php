<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\MasterJabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RiwayatKeluargaAnakController;
use App\Http\Controllers\RiwayatKeluargaOrangTuaController;
use App\Http\Controllers\RiwayatKeluargaSuamiIstriController;
use App\Http\Controllers\RiwayatPendidikanBahasaController;
use App\Http\Controllers\RiwayatPendidikanLanjutController;
use App\Http\Controllers\RiwayatPendidikanSekolahController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserPegawaiController;
use App\Http\Controllers\HukumanController;
use App\Http\Controllers\DiklatController;
use App\Http\Controllers\PenghargaanController;

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

        Route::middleware('role:superadmin')->group(function() {
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
        });

        // URL buat data user pegawai
        Route::get('/data_user_pegawai', [UserPegawaiController::class, 'index']);
        Route::get('/view_form_tambah_user_pegawai', [UserPegawaiController::class, 'create']);
        Route::get('/view_form_edit_user_pegawai/{user}', [UserPegawaiController::class, 'edit']);
        Route::post('/tambah_user_pegawai', [UserPegawaiController::class, 'store']);
        Route::put('/edit_data_user_pegawai', [UserPegawaiController::class, 'update']);
        Route::delete('/delete_user_pegawai/{user}', [UserPegawaiController::class, 'destroy']);
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

        Route::get('/orang_tua', [RiwayatKeluargaOrangTuaController::class, 'index']);
        Route::get('/orang_tua/view_form_tambah_orang_tua', [RiwayatKeluargaOrangTuaController::class, 'create']);
        Route::post('/orang_tua/tambah_data_orang_tua', [RiwayatKeluargaOrangTuaController::class, 'store']);
        Route::get('/orang_tua/view_form_edit_orang_tua/{riwayatKeluargaOrangTua}', [RiwayatKeluargaOrangTuaController::class, 'edit']);
        Route::put('/orang_tua/edit_data_orang_tua/{riwayatKeluargaOrangTua}', [RiwayatKeluargaOrangTuaController::class, 'update']);
        Route::delete('/orang_tua/delete_data_orang_tua/{riwayatKeluargaOrangTua}', [RiwayatKeluargaOrangTuaController::class, 'destroy']);
    });

    Route::prefix('riwayat_pendidikan')->group(function() {
        // URL Riwayat Pendidikan Sekolah
        Route::get('/sekolah', [RiwayatPendidikanSekolahController::class, 'index']);
        Route::get('/sekolah/view_form_tambah_pendidikan_sekolah', [RiwayatPendidikanSekolahController::class, 'create']);
        Route::post('/sekolah/tambah_pendidikan_sekolah', [RiwayatPendidikanSekolahController::class, 'store']);
        Route::get('/sekolah/view_form_edit_pendidikan_sekolah/{riwayatPendidikanSekolah}', [RiwayatPendidikanSekolahController::class, 'edit']);
        Route::put('/sekolah/edit_pendidikan_sekolah/{riwayatPendidikanSekolah}', [RiwayatPendidikanSekolahController::class, 'update']);
        Route::delete('/sekolah/delete_pendidikan_sekolah/{riwayatPendidikanSekolah}', [RiwayatPendidikanSekolahController::class, 'destroy']);

        // URL Riwayat Pendidikan lanjut
        Route::get('/sekolah_lanjut', [RiwayatPendidikanLanjutController::class, 'index']);
        Route::get('/sekolah_lanjut/view_form_tambah_pendidikan_lanjut', [RiwayatPendidikanLanjutController::class, 'create']);
        Route::post('/sekolah_lanjut/tambah_pendidikan_lanjut', [RiwayatPendidikanLanjutController::class, 'store']);
        Route::get('/sekolah_lanjut/view_form_edit_pendidikan_lanjut/{riwayatPendidikanLanjut}', [RiwayatPendidikanLanjutController::class, 'edit']);
        Route::put('/sekolah_lanjut/edit_pendidikan_lanjut/{riwayatPendidikanLanjut}', [RiwayatPendidikanLanjutController::class, 'update']);


        // URL Riwayat Pendidikan Bahasa
        Route::get('/pendidikan_bahasa', [RiwayatPendidikanBahasaController::class, 'index']);
        Route::get('/pendidikan_bahasa/view_form_tambah_pendidikan_bahasa', [RiwayatPendidikanBahasaController::class, 'create']);
        Route::post('/pendidikan_bahasa/tambah_data_bahasa', [RiwayatPendidikanBahasaController::class, 'store']);
        Route::get('/pendidikan_bahasa/view_form_edit_pendidikan_bahasa/{riwayatPendidikanBahasa}', [RiwayatPendidikanBahasaController::class, 'edit']);
        Route::put('/pendidikan_bahasa/edit_data_bahasa/{riwayatPendidikanBahasa}', [RiwayatPendidikanBahasaController::class, 'update']);
    });

    Route::prefix('kepegawaian')->group(function() {
        Route::get('/jabatan', [JabatanController::class, 'index']);
        Route::get('/jabatan/view_tambah_jabatan', [JabatanController::class, 'create']);

        // URL untuk master data jabatan
        Route::get('/jabatan/master_data_jabatan', [MasterJabatanController::class, 'index']);
        Route::get('/jabatan/master_data_jabatan/{masterJabatan}', [MasterJabatanController::class, 'index']);
        Route::post('/jabatan/tambah_data_master_jabatan', [MasterJabatanController::class, 'store']);


        Route::get('/pangkat');

        // URL Kepegawaian hukuman
        Route::get('/hukuman', [HukumanController::class, 'index']);
        Route::get('/hukuman/view_form_tambah_hukuman', [HukumanController::class, 'create']);
        Route::post('/hukuman/tambah_data_hukuman', [HukumanController::class, 'store']);
        Route::get('/hukuman/view_form_edit_hukuman/{hukuman}', [HukumanController::class, 'edit']);
        Route::put('/hukuman/edit_data_hukuman/{hukuman}', [HukumanController::class, 'update']);

        // URL Kepegawaian Diklat
        Route::get('/diklat', [DiklatController::class, 'index']);
        Route::get('/diklat/view_form_tambah_diklat', [DiklatController::class, 'create']);
        Route::post('/diklat/tambah_diklat', [DiklatController::class, 'store']);
        Route::get('/diklat/view_form_edit_diklat', [DiklatController::class, 'edit']);
        Route::put('/diklat/edit_diklat/{diklat}', [DiklatController::class, 'update']);
        Route::delete('/diklat/delete_data_diklat/{diklat}', [DiklatController::class, 'delete']);


        Route::get('/penghargaan', [PenghargaanController::class, 'index']);
        Route::get('/penghargaan/view_form_tambah_penghargaan', [PenghargaanController::class, 'create']);
        Route::post('/penghargaan/tambah_penghargaan', [PenghargaanController::class, 'store']);
        Route::get('/penghargaan/view_form_edit_penghargaan/{penghargaan}', [PenghargaanController::class, 'edit']);
        Route::put('/penghargaan/edit_penghargaan/{penghargaan}', [PenghargaanController::class, 'update']);

        // URL Kepegawaian Penugasan Luar Negeri
        Route::get('/penugasanln');

        // URL Kepegawaian Seminar
        Route::get('/seminar');


        // URL Kepegawaian Cuti
        Route::get('/cuti');
        Route::get('/latihan_jabatan');
        Route::get('/mutasi');
        Route::get('/tunjangan');
        Route::get('/izin_kawin');
    });

});
