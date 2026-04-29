<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unitkerja = UnitKerja::paginate(5);

        return view("pages.dashboard.manajemen_setup.OPD_SKD_UnitKerja.opd_skpd_unitkerja", [
            'unitkerja' => $unitkerja
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.dashboard.manajemen_setup.OPD_SKD_UnitKerja.tambahUnitKerja");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_unit' => 'required|string',
            'alamat' => 'required|string'
        ]);

        UnitKerja::create($validateData);

        return redirect('/manajemen_setup/opd_skpd_unitkerja')->with('success', 'Berhasil menambahkan data!');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitKerja $unitKerja)
    {
        return view("pages.dashboard.manajemen_setup.OPD_SKD_UnitKerja.editUnitKerja", [
            'unitKerja' => $unitKerja
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitKerja $unitKerja)
    {
        $validateData = $request->validate([
            'nama_unit' => 'required|string',
            'alamat' => 'required|string'
        ]);

        $unitKerja->update($validateData);

        return redirect('/manajemen_setup/opd_skpd_unitkerja')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitKerja $unitKerja)
    {
        $unitKerja->delete();

        return redirect('/manajemen_setup/opd_skpd_unitkerja')->with('success', 'Berhasil menghapus data!');
    }
}
