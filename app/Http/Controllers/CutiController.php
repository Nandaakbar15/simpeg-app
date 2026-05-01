<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Pegawai;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuti = Cuti::with('pegawai')->paginate(5);

        return view("pages.dashboard.kepegawaian.cuti.indexCuti", [
            'cuti' => $cuti
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.kepegawaian.cuti.tambahCuti", [
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
            'jenis_cuti' => 'required',
            'no_surat_cuti' => 'required|string',
            'tgl_surat_cuti' => 'required|date',
            'pelaksanaan_cuti_mulai' => 'required|date',
            'pelaksanaan_cuti_selesai' => 'required|date',
            'durasi_cuti' => 'required|string',
            'ketentuan_a' => 'required|string',
            'ketentuan_b' => 'required|string',
            'ketentuan_c' => 'required|string',
            'tebusan' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            Cuti::create($validateData);

            DB::commit();

            return redirect('/kepegawaian/cuti')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuti $cuti)
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.kepegawaian.cuti.editCuti", [
            'pegawai' => $pegawai,
            'cuti' => $cuti
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuti $cuti)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'jenis_cuti' => 'required',
            'no_surat_cuti' => 'required|string',
            'tgl_surat_cuti' => 'required|date',
            'pelaksanaan_cuti_mulai' => 'required|date',
            'pelaksanaan_cuti_selesai' => 'required|date',
            'durasi_cuti' => 'required|string',
            'ketentuan_a' => 'required|string',
            'ketentuan_b' => 'required|string',
            'ketentuan_c' => 'required|string',
            'tebusan' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $cuti->update($validateData);

            DB::commit();

            return redirect("/kepegawaian/cuti")->with('success', 'Berhasil mengubah data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengubah data : ' . $e->getMessage());

            return back()->withInput()->with('error', "Error, terjadi kesalahan pada sistem!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuti $cuti)
    {
        $cuti->delete();

        return redirect('/kepegawaian/cuti')->with('success', 'Berhasil menghapus data!');
    }

    /**
     * Download / cetak form surat cuti.
     */
    public function downloadSuratCuti(Cuti $cuti)
    {
        $cuti->load('pegawai.unit_kerja', 'pegawai.jabatan_aktif.master_jabatan');

        $instansi = \App\Models\InstansiLembaga::first();

        // Pangkat terakhir pegawai
        $pangkat = \App\Models\Pangkat::with(['master_pangkat', 'master_golongan'])
            ->where('pegawai_id', $cuti->pegawai_id)
            ->latest('tmt_pangkat_mulai')
            ->first();

        return view('pages.dashboard.kepegawaian.cuti.suratCuti', compact('cuti', 'instansi', 'pangkat'));
    }
}
