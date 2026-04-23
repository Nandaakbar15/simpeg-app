<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikanBahasa;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RiwayatPendidikanBahasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayatPendidikanBahasa = RiwayatPendidikanBahasa::with('pegawai')->paginate(5);

        return view("pages.dashboard.riwayat_pendidikan.pendidikan_bahasa.indexPendidikanBahasa", [
            'riwayatPendidikanBahasa' => $riwayatPendidikanBahasa
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.riwayat_pendidikan.pendidikan_bahasa.tambahPendidikanBahasa", [
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
            'jenis_bahasa' => 'required|string',
            'bahasa' => 'required|string',
            'kemampuan_bicara' => 'required'
        ]);

        try {
            DB::beginTransaction();

            RiwayatPendidikanBahasa::create($validateData);

            DB::commit();

            return redirect("/riwayat_pendidikan/pendidikan_bahasa")->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', "Error terjadi kesalahan pada sistem!");
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatPendidikanBahasa $riwayatPendidikanBahasa)
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.riwayat_pendidikan.pendidikan_bahasa.editPendidikanBahasa", [
            'pegawai' => $pegawai,
            'riwayatPendidikanBahasa' => $riwayatPendidikanBahasa
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatPendidikanBahasa $riwayatPendidikanBahasa)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'jenis_bahasa' => 'required|string',
            'bahasa' => 'required|string',
            'kemampuan_bicara' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $riwayatPendidikanBahasa->update($validateData);

            DB::commit();

            return redirect('/riwayat_pendidikan/pendidikan_bahasa')->with('success', 'Berhasil mengubah data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengubah data : ' . $e->getMessage());

            return back()->withInput()->with('error', "Error, terjadi kesalahan pada sistem!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatPendidikanBahasa $riwayatPendidikanBahasa)
    {
        $riwayatPendidikanBahasa->delete();

        return redirect('/riwayat_pendidikan/pendidikan_bahasa')->with('success', 'Berhasil menghapus data!');
    }
}
