<?php

namespace App\Http\Controllers;

use App\Models\Pangkat;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pegawai;
use App\Models\MasterPangkat;
use App\Models\MasterGolongan;

class PangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pangkat = Pangkat::with(['master_pangkat', 'master_golongan'])->paginate(5);

        return view("pages.dashboard.kepegawaian.pangkat.indexPangkat", [
            'pangkat' => $pangkat
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();
        $masterPangkat = MasterPangkat::all();
        $masterGolongan = MasterGolongan::all();

        return view("pages.dashboard.kepegawaian.pangkat.tambahPangkat", [
            'pegawai' => $pegawai,
            'masterPangkat' => $masterPangkat,
            'masterGolongan' => $masterGolongan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'master_pangkat_id' => 'required|exists:tb_master_pangkat,id',
            'master_golongan_id' => 'required|exists:tb_master_golongan,id',
            'jenis_pangkat' => 'required|string',
            'tmt_pangkat_mulai' => 'required|date',
            'tmt_pangkat_selesai' => 'required|date',
            'no_sk' => 'required|string',
            'tgl_sk' => 'required|date',
            'pejabat_pengesah_sk' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            Pangkat::create($validateData);

            DB::commit();

            return redirect('/kepegawaian/pangkat')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pangkat $pangkat)
    {
        $pegawai = Pegawai::all();
        $masterPangkat = MasterPangkat::all();
        $masterGolongan = MasterGolongan::all();

        return view("pages.dashboard.kepegawaian.pangkat.editPangkat", [
            'pegawai' => $pegawai,
            'masterPangkat' => $masterPangkat,
            'masterGolongan' => $masterGolongan,
            'pangkat' => $pangkat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pangkat $pangkat)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'master_pangkat_id' => 'required|exists:tb_master_pangkat,id',
            'master_golongan_id' => 'required|exists:tb_master_golongan,id',
            'jenis_pangkat' => 'required|string',
            'tmt_pangkat_mulai' => 'required|date',
            'tmt_pangkat_selesai' => 'required|date',
            'no_sk' => 'required|string',
            'tgl_sk' => 'required|date',
            'pejabat_pengesah_sk' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $pangkat->update($validateData);

            DB::commit();

            return redirect("/kepegawaian/pangkat")->with('success', 'Berhasil mengubah data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengubah data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pangkat $pangkat)
    {
        $pangkat->delete();

        return redirect('/kepegawaian/pangkat')->with('success', 'Berhasil menghapus data!');
    }
}
