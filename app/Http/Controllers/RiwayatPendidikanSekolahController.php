<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikanSekolah;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RiwayatPendidikanSekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayanPendidikanSekolah = RiwayatPendidikanSekolah::with('pegawai')->paginate(5);

        return view("pages.dashboard.riwayat_pendidikan.pendidikan_sekolah.indexPendidikanSekolah", [
            'riwayatPendidikanSekolah' => $riwayanPendidikanSekolah
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.riwayat_pendidikan.pendidikan_sekolah.tambahPendidikanSekolah", [
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
            'jenjang_pendidikan' => 'required',
            'nama_sekolah_universitas' => 'required|string',
            'lokasi' => 'required|string',
            'jurusan' => 'required|string',
            'no_ijazah' => 'required|string',
            'tgl_ijazah' => 'required|date',
            'nama_kepsek_rektor' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            RiwayatPendidikanSekolah::create($validateData);

            DB::commit();

            return redirect('/riwayat_pendidikan/sekolah')->with('success', 'Berhasil menyimpan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error("Gagal menyimpan data : " . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatPendidikanSekolah $riwayatPendidikanSekolah)
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.riwayat_pendidikan.pendidikan_sekolah.editPendidikanSekolah", [
            'pegawai' => $pegawai,
            'riwayatPendidikanSekolah' => $riwayatPendidikanSekolah
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatPendidikanSekolah $riwayatPendidikanSekolah)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'jenjang_pendidikan' => 'required',
            'nama_sekolah_universitas' => 'required|string',
            'lokasi' => 'required|string',
            'jurusan' => 'required|string',
            'no_ijazah' => 'required|string',
            'tgl_ijazah' => 'required|date',
            'nama_kepsek_rektor' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $riwayatPendidikanSekolah->update($validateData);

            DB::commit();

            return redirect('/riwayat_pendidikan/sekolah')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengubah data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatPendidikanSekolah $riwayatPendidikanSekolah)
    {
        $riwayatPendidikanSekolah->delete();

        return redirect('/riwayat_pendidikan/sekolah')->with('success', 'Berhasil menghapus data!');
    }
}
