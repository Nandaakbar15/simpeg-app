<?php

namespace App\Http\Controllers;

use App\Models\Diklat;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class DiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diklat = Diklat::with('pegawai')->paginate(5);

        return view("pages.dashboard.kepegawaian.diklat.indexDiklat", [
            'diklat' => $diklat
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.kepegawaian.diklat.tambahDiklat", [
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
            'nama_diklat' => 'required|string',
            'jumlah_jam' => 'required|string',
            'penyelenggara' => 'required|string',
            'tempat' => 'required|string',
            'angkatan' => 'required|string',
            'tahun' => 'required|string',
            'no_sttpp' => 'required|string',
            'tgl_sttpp' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            Diklat::create($validateData);

            DB::commit();

            return redirect('/kepegawaian/diklat')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diklat $diklat)
    {
        $pegawai = Pegawai::all();

        return view("pages.dashboard.kepegawaian.diklat.editDiklat", [
            'diklat' => $diklat,
            'pegawai' => $pegawai
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diklat $diklat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diklat $diklat)
    {
        //
    }
}
