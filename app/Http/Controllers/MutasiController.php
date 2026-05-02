<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\Pegawai;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $mutasi = Mutasi::with('pegawai')
                ->whereHas('pegawai', function($query) use ($user) {
                    $query->where('unit_kerja_id', $user->unit_kerja_id);
                })
                ->paginate(5);
        } else {
            $mutasi = Mutasi::with('pegawai')->paginate(5);
        }

        return view("pages.dashboard.kepegawaian.mutasi.indexMutasi", [
            'mutasi' => $mutasi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $pegawai = Pegawai::where('unit_kerja_id', $user->unit_kerja_id)->get();
        } else {
            $pegawai = Pegawai::all();
        }

        return view("pages.dashboard.kepegawaian.mutasi.tambahMutasi", [
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
            'jenis_mutasi' => 'required',
            'instansi_tujuan' => 'required|string',
            'no_sk_mutasi' => 'required|string',
            'tgl_sk_mutasi' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            Mutasi::create($validateData);

            DB::commit();

            return redirect('/kepegawaian/mutasi')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mutasi $mutasi)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $pegawai = Pegawai::where('unit_kerja_id', $user->unit_kerja_id)->get();
        } else {
            $pegawai = Pegawai::all();
        }

        return view("pages.dashboard.kepegawaian.mutasi.editMutasi", [
            'pegawai' => $pegawai,
            'mutasi' => $mutasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mutasi $mutasi)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'jenis_mutasi' => 'required',
            'instansi_tujuan' => 'required|string',
            'no_sk_mutasi' => 'required|string',
            'tgl_sk_mutasi' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            $mutasi->update($validateData);

            DB::commit();

            return redirect('/kepegawaian/mutasi')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengubah data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mutasi $mutasi)
    {
        $mutasi->delete();

        return redirect("/kepegawaian/mutasi")->with('success', 'Berhasil menghapus data!');
    }
}
