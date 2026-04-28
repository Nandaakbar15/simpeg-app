<?php

namespace App\Http\Controllers;

use App\Models\MasterPangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class MasterPangkatController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_pangkat' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $masterPangkat = MasterPangkat::create($validateData);

            DB::commit();

            return response()->json($masterPangkat);
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterPangkat $masterPangkat)
    {
        return view("pages.dashboard.kepegawaian.pangkat.master_pangkat.editMasterPangkat", [
            'masterPangkat' => $masterPangkat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterPangkat $masterPangkat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterPangkat $masterPangkat)
    {
        //
    }
}
