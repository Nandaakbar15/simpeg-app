<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKeluargaSuamiIstri;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RiwayatKeluargaSuamiIstriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayatkeluargaSuamiIstri = RiwayatKeluargaSuamiIstri::with('pegawai')->get();

        return view('pages.dashboard.riwayat_keluarga.suami_istri.indexKeluargaSuami_Istri', [
            'riwayatkeluargaSuamiIstri' => $riwayatkeluargaSuamiIstri
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.riwayat_keluarga.suami_istri.tambahKeluargaSuami_Istri", [
            'pegawai' => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'no_ktp_nik' => 'required|string',
            'nama' => 'required|string',
            'tgl_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_hubungan' => 'required'
        ]);

        try {
            DB::beginTransaction();

            RiwayatKeluargaSuamiIstri::create($validateData);

            DB::commit();

            return redirect('/riwayat_keluarga/suami_istri')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error("Gagal menyimpan data " . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan!');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatKeluargaSuamiIstri $riwayatKeluargaSuamiIstri)
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.riwayat_keluarga.suami_istri.editKeluargaSuami_Istri", [
            'pegawai' => $pegawai,
            'riwayatKeluargaSuamiIstri' => $riwayatKeluargaSuamiIstri
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatKeluargaSuamiIstri $riwayatKeluargaSuamiIstri)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'no_ktp_nik' => 'required|string',
            'nama' => 'required|string',
            'tgl_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_hubungan' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $riwayatKeluargaSuamiIstri->update($validateData);

            DB::commit();

            return redirect('/riwayat_keluarga/suami_istri')->with('success', 'Berhasil mengubah data!');


        } catch(Exception $e) {
            DB::rollBack();

            Log::error("Gagal mengubah data : " . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatKeluargaSuamiIstri $riwayatKeluargaSuamiIstri)
    {
        $riwayatKeluargaSuamiIstri->delete();

        return redirect('/riwayat_keluarga/suami_istri')->with('success', 'Berhasil menghapus data');
    }
}
