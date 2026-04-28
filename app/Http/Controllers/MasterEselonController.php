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
     * Display the specified resource.
     */
    public function show(MasterEselon $masterEselon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterEselon $masterEselon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterEselon $masterEselon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterEselon $masterEselon)
    {
        //
    }
}
