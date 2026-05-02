<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKeluargaAnak;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RiwayatKeluargaAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $riwayatKeluargaAnak = RiwayatKeluargaAnak::with('pegawai')
                ->whereHas('pegawai', function($query) use ($user) {
                    $query->where('unit_kerja_id', $user->unit_kerja_id);
                })
                ->get();
        } else {
            $riwayatKeluargaAnak = RiwayatKeluargaAnak::with('pegawai')->get();
        }

        return view("pages.dashboard.riwayat_keluarga.anak.IndexRiwayatKeluargaAnak", [
            'riwayatKeluargaAnak' => $riwayatKeluargaAnak
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

        return view("pages.dashboard.riwayat_keluarga.anak.tambahRiwayatKeluargaAnak", [
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
            'nik' => 'required|string',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'status_hubungan' => 'required'
        ]);

        try {
            DB::beginTransaction();

            RiwayatKeluargaAnak::create($validateData);

            DB::commit();

            return redirect('/riwayat_keluarga/anak')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error("Gagal menyimpan data : " . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatKeluargaAnak $riwayatKeluargaAnak)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $pegawai = Pegawai::where('unit_kerja_id', $user->unit_kerja_id)->get();
        } else {
            $pegawai = Pegawai::all();
        }

        return view("pages.dashboard.riwayat_keluarga.anak.EditRiwayatKeluargaAnak", [
            'pegawai' => $pegawai,
            'riwayatKeluargaAnak' => $riwayatKeluargaAnak
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatKeluargaAnak $riwayatKeluargaAnak)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'nik' => 'required|string',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'status_hubungan' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $riwayatKeluargaAnak->update($validateData);

            DB::commit();

            return redirect("/riwayat_keluarga/anak")->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error("Gagal menyimpan data : " . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatKeluargaAnak $riwayatKeluargaAnak)
    {
        $riwayatKeluargaAnak->delete();

        return redirect('/riwayat_keluarga/anak')->with('success', 'Berhasil menghapus data!');
    }
}
