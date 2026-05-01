<?php

namespace App\Http\Controllers;

use App\Models\MasterGolongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class MasterGolonganController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_golongan' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $masterGolongan = MasterGolongan::create($validateData);

            DB::commit();

            return response()->json($masterGolongan);
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterGolongan $masterGolongan)
    {
        return view("pages.dashboard.kepegawaian.pangkat.master_golongan.editMasterGolongan", [
            'masterGolongan' => $masterGolongan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterGolongan $masterGolongan)
    {
        $validateData = $request->validate([
            'nama_golongan' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $masterGolongan->update($validateData);

            DB::commit();

            return redirect('/kepegawaian/pangkat')->with('success', 'Berhasil mengubah master golongan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterGolongan $masterGolongan)
    {
        $masterGolongan->delete();

        return response()->json($masterGolongan);
    }
}
