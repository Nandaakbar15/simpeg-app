<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use App\Models\Pegawai;
use App\Models\InstansiLembaga;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PenghargaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penghargaan = Penghargaan::with('pegawai')->paginate(5);

        return view("pages.dashboard.kepegawaian.penghargaan.indexPenghargaan", [
            'penghargaan' => $penghargaan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.kepegawaian.penghargaan.tambahPenghargaan", [
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
            'nama_penghargaan' => 'required|string',
            'instansi_pemberi' => 'required|string',
            'tingkat_kegiatan' => 'required',
            'tempat_penghargaan' => 'required',
            'tgl_penghargaan' => 'required|date',
            'tahun' => 'required|string',
            'no_sertifikat' => 'required'
        ]);

        try {
            DB::beginTransaction();

            Penghargaan::create($validateData);

            DB::commit();

            return redirect("/kepegawaian/penghargaan")->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error("Gagal menyimpan data : " . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penghargaan $penghargaan)
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.kepegawaian.penghargaan.editPenghargaan", [
            'penghargaan' => $penghargaan,
            'pegawai' => $pegawai
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penghargaan $penghargaan)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'nama_penghargaan' => 'required|string',
            'instansi_pemberi' => 'required|string',
            'tingkat_kegiatan' => 'required',
            'tempat_penghargaan' => 'required',
            'tgl_penghargaan' => 'required|date',
            'tahun' => 'required|string',
            'no_sertifikat' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $penghargaan->update($validateData);

            DB::commit();

            return redirect("/kepegawaian/penghargaan")->with('success', 'Berhasil mengubah data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error("Gagal mengubah data : " . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penghargaan $penghargaan)
    {
        $penghargaan->delete();

        return redirect("/kepegawaian/penghargaan")->with('success', 'Berhasil menghapus data!');
    }

    /**
     * Download / cetak sertifikat penghargaan.
     */
    public function downloadSertifikat(Penghargaan $penghargaan)
    {
        $penghargaan->load('pegawai.unit_kerja');
        $instansi = \App\Models\InstansiLembaga::first();

        return view('pages.dashboard.kepegawaian.penghargaan.sertifikatPenghargaan', [
            'penghargaan' => $penghargaan,
            'instansi'    => $instansi,
        ]);
    }
}
