<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Pegawai;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $seminar = Seminar::with('pegawai')
                ->whereHas('pegawai', function($query) use ($user) {
                    $query->where('unit_kerja_id', $user->unit_kerja_id);
                })
                ->paginate(5);
        } else {
            $seminar = Seminar::with('pegawai')->paginate(5);
        }

        return view("pages.dashboard.kepegawaian.seminar.indexSeminar", [
            'seminar' => $seminar
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

        return view("pages.dashboard.kepegawaian.seminar.tambahSeminar", [
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
            'nama_seminar' => 'required|string',
            'tingkat_kegiatan' => 'required|string',
            'tempat_seminar' => 'required|string',
            'tgl_seminar' => 'required|date',
            'penyelenggara' => 'required|string',
            'jumlah_jam' => 'required|string',
            'no_piagam' => 'required|string',
            'tgl_piagam' => 'required|date',
            'file_piagam' => 'required|file|mimes:pdf,docx,txt|max:10240'
        ]);

        try {
            DB::beginTransaction();

            if($request->hasFile('file_piagam')) {
                $file = $request->file('file_piagam');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('document', $fileName, 'public');
                $validateData['file_piagam'] = '/storage/' . $path;
            }

            Seminar::create($validateData);

            DB::commit();

            return redirect('/kepegawaian/seminar')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal menambahkan data : ' . $e->getMessage());

            return back()->withInput()->with('Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seminar $seminar)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $pegawai = Pegawai::where('unit_kerja_id', $user->unit_kerja_id)->get();
        } else {
            $pegawai = Pegawai::all();
        }

        return view("pages.dashboard.kepegawaian.seminar.editSeminar", [
            'pegawai' => $pegawai,
            'seminar' => $seminar
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seminar $seminar)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'required|exists:tb_pegawai,id',
            'nama_seminar' => 'required|string',
            'tingkat_kegiatan' => 'required|string',
            'tempat_seminar' => 'required|string',
            'tgl_seminar' => 'required|date',
            'penyelenggara' => 'required|string',
            'jumlah_jam' => 'required|string',
            'no_piagam' => 'required|string',
            'tgl_piagam' => 'required|date',
            'file_piagam' => 'file|mimes:pdf,docx,txt|max:10240'
        ]);

        try {
            DB::beginTransaction();

            if($request->hasFile('file_piagam')) {

                if($request->fileLama) {
                    Storage::disk('public')->delete($request->fileLama);
                }

                $file = $request->file('file_piagam');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('images', $fileName, 'public');
                $validateData['file_piagam'] = '/storage/' . $path;
            }

            $seminar->update($validateData);

            DB::commit();

            return redirect('/kepegawaian/seminar')->with('success', 'Berhasil menambahkan data!');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('Gagal mengubah data : ' . $e->getMessage());

            return back()->withInput()->with('error', 'terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seminar $seminar)
    {
        $seminar->delete();

        return redirect("success", 'Berhasil menghapus data!');
    }

    public function downloadPiagam(Seminar $seminar)
    {
        $filePath = str_replace('/storage/', '', trim($seminar->file_piagam));

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download(storage_path('app/public/' . $filePath));
    }
}
