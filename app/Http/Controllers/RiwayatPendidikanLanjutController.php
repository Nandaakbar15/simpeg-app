<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikanLanjut;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr;

class RiwayatPendidikanLanjutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayatPendidikanLanjut = RiwayatPendidikanLanjut::with('pegawai')->paginate(5);

        return view("pages.dashboard.riwayat_pendidikan.pendidikan_lanjut.indexPendidikanLanjut", [
            'riwayatPendidikanLanjut' => $riwayatPendidikanLanjut
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.riwayat_pendidikan.pendidikan_lanjut.tambahPendidikanLanjut", [
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
            'nama_sekolah_universitas' => 'required',
            'jurusan' => 'required',
            'thn_mulai' => 'required',
            'thn_selesai' => 'required',
            'status' => 'required'
        ]);

        try {
            DB::beginTransaction();

            RiwayatPendidikanLanjut::create($validateData);

            DB::commit();

            return redirect('/riwayat_pendidikan/sekolah_lanjut')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', "Error, terjadi kesalahan!");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatPendidikanLanjut $riwayatPendidikanLanjut)
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.riwayat_pendidikan.pendidikan_lanjut.editPendidikanLanjut", [
            'pegawai' => $pegawai,
            'riwayatPendidikanLanjut' => $riwayatPendidikanLanjut
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatPendidikanLanjut $riwayatPendidikanLanjut)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'jenjang_pendidikan' => 'required',
            'jurusan' => 'required',
            'thn_mulai' => 'required',
            'thn_selesai' => 'required',
            'status' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $riwayatPendidikanLanjut->update($validateData);

            DB::commit();

            return redirect('/riwayat_pendidikan/sekolah_lanjut')->with('success', 'Berhasil mengubah data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengubah data : ' . $e->getMessage());

            return back()->withInput()->with('error', "Error, terjadi kesalahan pada sistem!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatPendidikanLanjut $riwayatPendidikanLanjut)
    {
        $riwayatPendidikanLanjut->delete();

        return redirect('/riwayat_pendidikan/pendidikan_lanjut')->with('success', 'Berhasil menghapus data!');
    }
}
