<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\MasterGolongan;
use App\Models\MasterPangkat;
use App\Models\MasterJabatan;
use App\Models\MasterEselon;
use App\Models\RiwayatPendidikanSekolah;
use App\Models\RiwayatPendidikanLanjut;

class RekapitulasiController extends Controller
{
    public function rekapUnitKerja()
    {
        $unitKerja = UnitKerja::withCount('pegawai')->get();

        $chartCategories = $unitKerja->pluck('nama_unit')->toArray();
        $chartData = $unitKerja->pluck('pegawai_count')->toArray();

        return view("pages.dashboard.rekapitulasi.rekapUnitKerja", [
            'unitKerja' => $unitKerja,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

    public function rekapGolongan()
    {
        $golongan = MasterGolongan::withCount('pegawai')->get();

        $chartCategories = $golongan->pluck('nama_golongan')->toArray();
        $chartData = $golongan->pluck('pegawai_count')->toArray();

        return view("pages.dashboard.rekapitulasi.rekapGolongan", [
            'golongan' => $golongan,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

    public function rekapPangkat()
    {
        $pangkat = MasterPangkat::withCount("pegawai")->get();

        $chartCategories = $pangkat->pluck('nama_pangkat')->toArray();
        $chartData = $pangkat->pluck('pegawai_count')->toArray();

        return view("pages.dashboard.rekapitulasi.rekapPangkat", [
            'pangkat' => $pangkat,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

    public function rekapJabatan()
    {
        $jabatan = MasterJabatan::withCount("pegawai")->get();

        $chartCategories = $jabatan->pluck('nama_jabatan')->toArray();
        $chartData = $jabatan->pluck('pegawai_count')->toArray();

        return view("pages.dashboard.rekapitulasi.rekapJabatan", [
            'jabatan' => $jabatan,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

    public function rekapEselon()
    {
        $eselon = MasterEselon::withCount("pegawai")->get();

        $chartCategories = $eselon->pluck('nama_eselon')->toArray();
        $chartData = $eselon->pluck("pegawai_count")->toArray();

        return view("pages.dashboard.rekapitulasi.rekapEselon", [
            'eselon' => $eselon,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

    public function rekapStatusKepegawaian()
    {
        $statusKepegawaian = Pegawai::selectRaw("status_kepegawaian, count(*) as jumlah")
                                     ->groupBy('status_kepegawaian')
                                     ->get();

        $chartCategories = $statusKepegawaian->pluck("status_kepegawaian")->toArray();
        $chartData = $statusKepegawaian->pluck('jumlah')->toArray();

        return view("pages.dashboard.rekapitulasi.rekapStatusKepegawaian", [
            'statusKepegawaian' => $statusKepegawaian,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

    public function rekapAgama()
    {
        $agama = Pegawai::selectRaw("agama, count(*) as jumlah")
                         ->groupBy("agama")
                         ->get();

        $chartCategories = $agama->pluck("agama")->toArray();
        $chartData = $agama->pluck("jumlah")->toArray();

        return view("pages.dashboard.rekapitulasi.rekapAgama", [
            'agama' => $agama,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

    public function rekapJenisKelamin()
    {
        $jenisKelamin = Pegawai::selectRaw("jenis_kelamin, count(*) as jumlah")
                                ->groupBy("jenis_kelamin")
                                ->get();

        $chartCategories = $jenisKelamin->pluck("jenis_kelamin")->toArray();
        $chartData = $jenisKelamin->pluck("jumlah")->toArray();

        return view("pages.dashboard.rekapitulasi.rekapJenisKelamin", [
            'jenisKelamin' => $jenisKelamin,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

    public function rekapStatusPernikahan()
    {
        $statusPernikahan = Pegawai::selectRaw("status_pernikahan, count(*) as jumlah")
                                   ->groupBy("status_pernikahan")
                                   ->get();

        $chartCategories = $statusPernikahan->pluck("status_pernikahan")->toArray();
        $chartData = $statusPernikahan->pluck("jumlah")->toArray();

        return view("pages.dashboard.rekapitulasi.rekapStatusNikah", [
            'statusPernikahan' => $statusPernikahan,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

    public function rekapPendidikanAkhir()
    {
        // Ambil pendidikan tertinggi per pegawai berdasarkan urutan jenjang,
        // lalu group by jenjang_pendidikan untuk menghitung jumlah pegawai.
        // Urutan jenjang: SD < SMP < SMA/SMK < D1 < D2 < D3 < D4 < S1 < S2 < S3
        $jenjangOrder = ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];

        // Subquery: ambil jenjang_pendidikan terbaru (FIELD order) per pegawai_id
        // Karena tidak ada kolom "level", kita ambil semua record lalu proses di PHP
        $semuaRiwayat = RiwayatPendidikanSekolah::select('pegawai_id', 'jenjang_pendidikan')->get();

        // Juga gabungkan dari pendidikan lanjut (D1-S3)
        $riwayatLanjut = \App\Models\RiwayatPendidikanLanjut::select('pegawai_id', 'jenjang_pendidikan')->get();

        $semuaRiwayat = $semuaRiwayat->concat($riwayatLanjut);

        // Untuk setiap pegawai, ambil jenjang tertinggi
        $pendidikanPerPegawai = $semuaRiwayat
            ->groupBy('pegawai_id')
            ->map(function ($records) use ($jenjangOrder) {
                $tertinggi = $records->sortByDesc(function ($r) use ($jenjangOrder) {
                    $idx = array_search(strtoupper(trim($r->jenjang_pendidikan)), $jenjangOrder);
                    return $idx !== false ? $idx : -1;
                })->first();
                return $tertinggi->jenjang_pendidikan;
            });

        // Group by jenjang dan hitung
        $grouped = $pendidikanPerPegawai
            ->groupBy(fn($j) => $j)
            ->map(fn($items, $jenjang) => [
                'jenjang_pendidikan' => $jenjang,
                'jumlah'             => $items->count(),
            ])
            ->values()
            ->sortByDesc(fn($item) => array_search(strtoupper(trim($item['jenjang_pendidikan'])), $jenjangOrder))
            ->values();

        $chartCategories = $grouped->pluck('jenjang_pendidikan')->toArray();
        $chartData       = $grouped->pluck('jumlah')->toArray();

        return view("pages.dashboard.rekapitulasi.rekapPendidikanAkhir", [
            'pendidikanAkhir' => $grouped,
            'chartCategories' => $chartCategories,
            'chartData'       => $chartData,
        ]);
    }

}
