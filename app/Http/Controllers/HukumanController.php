<?php

namespace App\Http\Controllers;

use App\Models\Hukuman;
use App\Models\Pegawai;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class HukumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hukuman = Hukuman::with('pegawai')->paginate(5);

        return view("pages.dashboard.kepegawaian.hukuman.indexHukuman", [
            'hukuman' => $hukuman
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.kepegawaian.hukuman.tambahHukuman", [
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
            'pelanggaran_yg_dilakukan' => 'required|string',
            'tingkat_hukuman' => 'required',
            'jenis_hukuman' => 'required',
            'isi_hukuman' => 'required|string',
            'pejabat_pengesahan_hukuman' => 'required|string',
            'no_sk' => 'required|string',
            'tgl_pengesahan_sk' => 'required|date',
            'tmt_hukuman_mulai' => 'required|date',
            'tmt_hukuman_pemulihan' => 'required|date',
            'pejabat_pemulihan_hukuman' => 'required|string',
            'no_pemulihan_hukuman' => 'required|string',
            'tgl_pemulihan_hukuman' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            Hukuman::create($validateData);

            DB::commit();

            return redirect('/kepegawaian/hukuman')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Hukuman $hukuman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hukuman $hukuman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hukuman $hukuman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hukuman $hukuman)
    {
        //
    }
}
