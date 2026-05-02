<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\MasterJabatan;
use App\Models\MasterEselon;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $jabatan = Jabatan::with(['master_jabatan', 'master_eselon', 'pegawai'])
                ->whereHas('pegawai', function($query) use ($user) {
                    $query->where('unit_kerja_id', $user->unit_kerja_id);
                })
                ->paginate(5);
        } else {
            $jabatan = Jabatan::with(['master_jabatan', 'master_eselon'])->paginate(5);
        }

        return view("pages.dashboard.kepegawaian.jabatan.indexJabatan", [
            'jabatan' => $jabatan
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

        $masterJabatan = MasterJabatan::all();
        $masterEselon = MasterEselon::all();
        return view("pages.dashboard.kepegawaian.jabatan.tambahJabatan", [
            'pegawai' => $pegawai,
            'masterJabatan' => $masterJabatan,
            'masterEselon' => $masterEselon
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'master_jabatan_id' => 'required|exists:tb_master_jabatan,id',
            'master_eselon_id' => 'required|exists:tb_master_eselon,id',
            'jenis_jabatan' => 'required',
            'tmt_jabatan_mulai' => 'required|date',
            'tmt_jabatan_selesai' => 'required|date',
            'periode' => 'required',
            'tahun_ke' => 'required',
            'no_sk' => 'required|string',
            'tgl_sk' => 'required|date',
            'terbit' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            Jabatan::create($validateData);

            DB::commit();

            return redirect('/kepegawaian/jabatan')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $pegawai = Pegawai::where('unit_kerja_id', $user->unit_kerja_id)->get();
        } else {
            $pegawai = Pegawai::all();
        }

        $masterJabatan = MasterJabatan::all();
        $masterEselon = MasterEselon::all();

        return view("pages.dashboard.kepegawaian.jabatan.editJabatan", [
            'pegawai' => $pegawai,
            'masterJabatan' => $masterJabatan,
            'masterEselon' => $masterEselon,
            'jabatan' => $jabatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'master_jabatan_id' => 'required|exists:tb_master_jabatan,id',
            'master_eselon_id' => 'required|exists:tb_master_eselon,id',
            'jenis_jabatan' => 'required',
            'tmt_jabatan_mulai' => 'required|date',
            'tmt_jabatan_selesai' => 'required|date',
            'periode' => 'required',
            'tahun_ke' => 'required',
            'no_sk' => 'required|string',
            'tgl_sk' => 'required|date',
            'terbit' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $jabatan->update($validateData);

            DB::commit();

            return redirect('/kepegawaian/jabatan')->with('success', 'Berhasil mengubah data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengubah data : ' . $e->getMessage());

            return back()->withInput()->with('error', "Error, terjadi kesalahan pada sistem!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return redirect('/kepegawaian/jabatan');
    }
}
