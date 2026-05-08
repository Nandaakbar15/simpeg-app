<?php

namespace App\Http\Controllers;

use App\Models\Diklat;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Storage;

class DiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $diklat = Diklat::with('pegawai')
                ->whereHas('pegawai', function($query) use ($user) {
                    $query->where('unit_kerja_id', $user->unit_kerja_id);
                })
                ->paginate(5);
        } else {
            $diklat = Diklat::with('pegawai')->paginate(5);
        }

        return view("pages.dashboard.kepegawaian.diklat.indexDiklat", [
            'diklat' => $diklat
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $pegawai = Pegawai::where('unit_kerja_id', $user->unit_kerja_id)->get();
        } else {
            $pegawai = Pegawai::all();
        }

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
            'tgl_sttpp' => 'required|date',
            'file_sertifikat_diklat' => 'required|file|mimes:pdf,docx,txt|max:10240'
        ]);

        try {
            DB::beginTransaction();

            if($request->hasFile('file_sertifikat_diklat')) {
                $file = $request->file('file_sertifikat_diklat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('document', $fileName, 'public');
                $validateData['file_sertifikat_diklat'] = '/storage/' . $path;
            }

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
        $user = Auth::user();

        if ($user->role === 'admin') {
            $pegawai = Pegawai::where('unit_kerja_id', $user->unit_kerja_id)->get();
        } else {
            $pegawai = Pegawai::all();
        }

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
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'nama_diklat' => 'required|string',
            'jumlah_jam' => 'required|string',
            'penyelenggara' => 'required|string',
            'tempat' => 'required|string',
            'angkatan' => 'required|string',
            'tahun' => 'required|string',
            'no_sttpp' => 'required|string',
            'tgl_sttpp' => 'required|date',
            'file_sertifikat_diklat' => 'nullable|file|mimes:pdf,docx,txt|max:10240'
        ]);

        try {
            DB::beginTransaction();

            if($request->hasFile('file_sertifikat_diklat')) {

                if($diklat->file_sertifikat_diklat) {
                    $oldPath = str_replace('/storage/', '', $diklat->file_sertifikat_diklat);
                    Storage::disk('public')->delete($oldPath);
                }

                $file = $request->file('file_sertifikat_diklat');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('document', $fileName, 'public');
                $validateData['file_sertifikat_diklat'] = '/storage/' . $path;
            } else {
                unset($validateData['file_sertifikat_diklat']);
            }

            $diklat->update($validateData);

            DB::commit();

            return redirect('/kepegawaian/diklat')->with('success', 'Berhasil mengubah data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengubah data : ' . $e->getMessage());

            return back()->withInput()->with('Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diklat $diklat)
    {
        try {
            $diklat->delete();
            return redirect('/kepegawaian/diklat')->with('success', 'Berhasil menghapus data!');
        } catch(Exception $e) {
            Log::error('Gagal menghapus data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    public function downloadSertifikatDiklat(Diklat $diklat)
    {
        $filePath = str_replace('/storage/', '', trim($diklat->file_sertifikat_diklat));

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download(storage_path('app/public/' . $filePath));
    }

    public function cariDiklat(Request $request)
    {
        $user = Auth::user();

        $query = Diklat::with('pegawai');

        // Filter berdasarkan role admin
        if ($user->role === 'admin') {
            $query->whereHas('pegawai', function($q) use ($user) {
                $q->where('unit_kerja_id', $user->unit_kerja_id);
            });
        }

        if($request->cariDiklat) {
            $query->where(function($q) use ($request) {

                // dari tabel izin kawin
                $q->where('nama_diklat', 'like', '%' . $request->cariDiklat . '%');

                $q->orWhere('penyelenggara', 'like', '%' . $request->cariDiklat . '%');

                $q->orWhere('tahun', 'like', '%' . $request->cariDiklat . '%')

                // dari relasi pegawai
                ->orWhereHas('pegawai', function($q2) use ($request) {
                    $q2->where('nama', 'like', '%' . $request->cariDiklat . '%');
                });

            });
        }

        $diklat = $query->paginate(5);

        return view("pages.dashboard.kepegawaian.diklat.indexDiklat", [
            'diklat' => $diklat
        ]);
    }
}
