<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pangkat;
use App\Models\Jabatan;
use App\Models\RiwayatPendidikanSekolah;
use App\Models\RiwayatPendidikanLanjut;
use App\Models\RiwayatPendidikanBahasa;
use App\Models\RiwayatKeluargaSuamiIstri;
use App\Models\RiwayatKeluargaAnak;
use App\Models\RiwayatKeluargaOrangtua;
use App\Models\Hukuman;
use App\Models\Penghargaan;
use App\Models\Diklat;
use App\Models\Seminar;
use App\Models\LatihanJabatan;
use App\Models\Cuti;
use App\Models\Tunjangan;
use App\Models\Mutasi;
use App\Models\IzinKawin;
use App\Models\PrestasiKerja;
use App\Models\Tpp;
use Illuminate\Http\Request;

class ProfilePegawaiController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $pegawai = Pegawai::with(['unit_kerja'])
            ->where('user_id', $user->id)
            ->first();

        if (!$pegawai) {
            return view('pages.dashboard.profile_pegawai.indexProfilePegawai', [
                'pegawai'     => null,
                'user'        => $user,
                'pangkat'     => null,
                'jabatan'     => null,
                'pendidikan'  => collect(),
                'keluarga'    => [],
                'kepegawaian' => [],
            ]);
        }

        // Pangkat terakhir
        $pangkat = Pangkat::with(['master_pangkat', 'master_golongan'])
            ->where('pegawai_id', $pegawai->id)
            ->latest('tmt_pangkat_mulai')
            ->first();

        // Jabatan aktif
        $jabatan = Jabatan::with(['master_jabatan', 'master_eselon'])
            ->where('pegawai_id', $pegawai->id)
            ->latest('tmt_jabatan_mulai')
            ->first();

        // Semua riwayat pendidikan
        $pendidikanSekolah = RiwayatPendidikanSekolah::where('pegawai_id', $pegawai->id)->get();
        $pendidikanLanjut  = RiwayatPendidikanLanjut::where('pegawai_id', $pegawai->id)->get();
        $pendidikanBahasa  = RiwayatPendidikanBahasa::where('pegawai_id', $pegawai->id)->get();

        // Keluarga
        $suamiIstri = RiwayatKeluargaSuamiIstri::where('pegawai_id', $pegawai->id)->get();
        $anak       = RiwayatKeluargaAnak::where('pegawai_id', $pegawai->id)->get();
        $orangTua   = RiwayatKeluargaOrangtua::where('pegawai_id', $pegawai->id)->get();

        // Kepegawaian
        $hukuman      = Hukuman::where('pegawai_id', $pegawai->id)->get();
        $penghargaan  = Penghargaan::where('pegawai_id', $pegawai->id)->get();
        $diklat       = Diklat::where('pegawai_id', $pegawai->id)->get();
        $seminar      = Seminar::where('pegawai_id', $pegawai->id)->get();
        $latihanJab   = LatihanJabatan::where('pegawai_id', $pegawai->id)->get();
        $cuti         = Cuti::where('pegawai_id', $pegawai->id)->get();
        $tunjangan    = Tunjangan::where('pegawai_id', $pegawai->id)->get();
        $mutasi       = Mutasi::where('pegawai_id', $pegawai->id)->get();
        $izinKawin    = IzinKawin::where('pegawai_id', $pegawai->id)->get();

        // SKP & TPP
        $skp          = PrestasiKerja::where('pegawai_id', $pegawai->id)->orderBy('tahun_periode', 'desc')->get();
        $tpp          = Tpp::where('pegawai_id', $pegawai->id)->orderBy('tahun', 'desc')->orderBy('periode', 'desc')->get();

        // Semua riwayat pangkat (KGB)
        $allPangkat   = Pangkat::with(['master_pangkat', 'master_golongan'])
            ->where('pegawai_id', $pegawai->id)
            ->orderBy('tmt_pangkat_mulai', 'desc')
            ->get();

        // Usia
        $usia = $pegawai->tgl_lahir
            ? \Carbon\Carbon::parse($pegawai->tgl_lahir)->diff(now())
            : null;

        return view('pages.dashboard.profile_pegawai.indexProfilePegawai', compact(
            'user', 'pegawai', 'pangkat', 'jabatan', 'usia',
            'pendidikanSekolah', 'pendidikanLanjut', 'pendidikanBahasa',
            'suamiIstri', 'anak', 'orangTua',
            'hukuman', 'penghargaan', 'diklat', 'seminar',
            'latihanJab', 'cuti', 'tunjangan', 'mutasi', 'izinKawin',
            'skp', 'tpp', 'allPangkat'
        ));
    }
}
