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
        $pendidikanAkhir = RiwayatPendidikanSekolah::withCount("pegawai")->get();

        $chartCategories = $pendidikanAkhir->pluck("jenjang_pendidikan")->toArray();
        $chartData = $pendidikanAkhir->pluck("pegawai_count")->toArray();

        return view("pages.dashboard.rekapitulasi.rekapPendidikanAkhir", [
            'pendidikanAkhir' => $pendidikanAkhir,
            'chartCategories' => $chartCategories,
            'chartData' => $chartData
        ]);
    }

}
