<?php

namespace App\Http\Controllers;

use App\Models\MasterEselon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class MasterEselonController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_eselon' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $eselon = MasterEselon::create($validateData);

            DB::commit();

            return response()->json($eselon);
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterEselon $masterEselon)
    {
        return view("pages.dashboard.kepegawaian.jabatan.master_eselon.editMasterEselon", [
            'masterEselon' => $masterEselon
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterEselon $masterEselon)
    {
        $validateData = $request->validate([
            'nama_eselon' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $eselon = MasterEselon::create($validateData);

            DB::commit();

            return redirect("/kepegawaian/jabatan")->with('success', 'Berhasil mengubah data master eselon!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterEselon $masterEselon)
    {
        $masterEselon->delete();

        return response()->json($masterEselon);
    }
}
