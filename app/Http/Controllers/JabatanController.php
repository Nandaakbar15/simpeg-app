<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\MasterJabatan;
use App\Models\Eselon;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatan = Jabatan::with(['master_jabatan', 'eselon'])->paginate(5);

        return view("pages.dashboard.kepegawaian.jabatan.indexJabatan", [
            'jabatan' => $jabatan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::all();
        $masterJabatan = MasterJabatan::all();
        $eselon = Eselon::all();
        return view("pages.dashboard.kepegawaian.jabatan.tambahJabatan", [
            'pegawai' => $pegawai,
            'masterJabatan' => $masterJabatan,
            'eselon' => $eselon
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        //
    }
}
