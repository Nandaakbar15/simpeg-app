<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataFeed;
use App\Models\Pegawai;
use App\Models\Cuti;
use App\Models\Diklat;
use App\Models\Penghargaan;
use App\Models\Jabatan;
use App\Models\Eselon;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Role pegawai langsung diarahkan ke halaman profil
        if (auth()->user()->role === 'pegawai') {
            return redirect()->route('profile.pegawai');
        }

        // Statistik Kartu
        $totalPegawai = Pegawai::count();
        $totalOPD = UnitKerja::count();
        $totalDiklat = Diklat::count();
        $totalPenghargaan = Penghargaan::count();

        // Data untuk chart - Statistik Jumlah Pegawai Berdasarkan OPD/SKPD/Unit Kerja
        // Coba ambil dari database, fallback ke dummy jika kosong
        $pegawaiPerUnitKerjaDb = Pegawai::select('unit_kerja_id', DB::raw('count(*) as total'))
            ->groupBy('unit_kerja_id')
            ->with('unit_kerja')
            ->get();

        if ($pegawaiPerUnitKerjaDb->count() > 0) {
            $pegawaiPerUnitKerja = $pegawaiPerUnitKerjaDb->map(function($item) {
                return [
                    'unit_kerja' => $item->unit_kerja->nama_unit ?? 'Tidak Ada Unit',
                    'total' => $item->total
                ];
            })->values()->toArray();
        } else {
            // Data dummy OPD/Unit Kerja
            $pegawaiPerUnitKerja = [
                ['unit_kerja' => 'Sekretariat Daerah', 'total' => 8],
                ['unit_kerja' => 'Sekretariat DPRD', 'total' => 5],
                ['unit_kerja' => 'Inspektorat', 'total' => 4],
                ['unit_kerja' => 'Dinas Pendidikan dan Kebudayaan', 'total' => 11],
                ['unit_kerja' => 'Dinas Lingkup SD', 'total' => 7],
                ['unit_kerja' => 'Dinas Kesehatan', 'total' => 3],
                ['unit_kerja' => 'Dinas PUPR', 'total' => 2],
                ['unit_kerja' => 'Badan Perencanaan Pembangunan Daerah', 'total' => 6],
                ['unit_kerja' => 'Badan Pengelolaan Keuangan Daerah', 'total' => 10],
                ['unit_kerja' => 'Badan Kepegawaian dan Pengembangan SDM (BKPSDM)', 'total' => 9],
                ['unit_kerja' => 'BPBD', 'total' => 4],
                ['unit_kerja' => 'RSUD Cilacap', 'total' => 7],
            ];
        }

        // Berkala Gaji 1 Bulan Kedepan (Data dummy)
        $gajiMendatang = [
            ['nip' => '196101091982031012', 'nama' => 'Nia Ramdani, S.H', 'ttl' => 'Banjarnegara, 1961-09-17', 'periode' => '2026-05-25'],
            ['nip' => '197803152003121005', 'nama' => 'Ahmad Fauzi, S.Kom', 'ttl' => 'Purwokerto, 1978-03-15', 'periode' => '2026-05-28'],
            ['nip' => '198507222010012018', 'nama' => 'Siti Nurhaliza, S.Pd', 'ttl' => 'Cilacap, 1985-07-22', 'periode' => '2026-06-01'],
            ['nip' => '199001102015031002', 'nama' => 'Budi Santoso, S.E', 'ttl' => 'Kebumen, 1990-01-10', 'periode' => '2026-06-03'],
        ];

        // Berkala Pangkat 1 Bulan Kedepan (Data dummy)
        $pangkatMendatang = [
            ['nip' => '197205141998031007', 'nama' => 'Dewi Lestari, S.Sos', 'ttl' => 'Yogyakarta, 1972-05-14', 'periode' => '2026-05-30'],
            ['nip' => '198812202012121003', 'nama' => 'Hendra Wijaya, S.T', 'ttl' => 'Semarang, 1988-12-20', 'periode' => '2026-06-02'],
            ['nip' => '197609081999032011', 'nama' => 'Ratna Dewi, M.Si', 'ttl' => 'Bandung, 1976-09-08', 'periode' => '2026-06-05'],
        ];

        // Statistik Golongan (Data dummy)
        $statistikGolongan = [
            ['golongan' => 'I/a', 'jumlah' => 3],
            ['golongan' => 'I/b', 'jumlah' => 5],
            ['golongan' => 'I/c', 'jumlah' => 7],
            ['golongan' => 'I/d', 'jumlah' => 4],
            ['golongan' => 'II/a', 'jumlah' => 12],
            ['golongan' => 'II/b', 'jumlah' => 18],
            ['golongan' => 'II/c', 'jumlah' => 15],
            ['golongan' => 'II/d', 'jumlah' => 10],
            ['golongan' => 'III/a', 'jumlah' => 22],
            ['golongan' => 'III/b', 'jumlah' => 28],
            ['golongan' => 'III/c', 'jumlah' => 25],
            ['golongan' => 'III/d', 'jumlah' => 20],
            ['golongan' => 'IV/a', 'jumlah' => 16],
            ['golongan' => 'IV/b', 'jumlah' => 11],
            ['golongan' => 'IV/c', 'jumlah' => 7],
            ['golongan' => 'IV/d', 'jumlah' => 4],
            ['golongan' => 'IV/e', 'jumlah' => 2],
        ];

        // Statistik Eselon (Data dummy)
        $statistikEselon = [
            ['eselon' => 'Eselon I/a', 'jumlah' => 2],
            ['eselon' => 'Eselon I/b', 'jumlah' => 4],
            ['eselon' => 'Eselon II/a', 'jumlah' => 7],
            ['eselon' => 'Eselon II/b', 'jumlah' => 10],
            ['eselon' => 'Eselon III/a', 'jumlah' => 14],
            ['eselon' => 'Eselon III/b', 'jumlah' => 18],
            ['eselon' => 'Eselon IV/a', 'jumlah' => 22],
            ['eselon' => 'Eselon IV/b', 'jumlah' => 19],
            ['eselon' => 'Eselon V/a', 'jumlah' => 12],
        ];

        // Statistik Jenis Kelamin (Data dummy)
        $statistikJenisKelamin = [
            ['jenis' => 'Laki-laki', 'jumlah' => 32],
            ['jenis' => 'Perempuan', 'jumlah' => 23],
        ];

        // Statistik Status Kepegawaian (Data dummy)
        $statistikStatus = [
            ['status' => 'PNS', 'jumlah' => 48],
            ['status' => 'CPNS', 'jumlah' => 5],
            ['status' => 'PPPK', 'jumlah' => 2],
        ];

        return view('pages/dashboard/dashboard', compact(
            'totalPegawai',
            'totalOPD',
            'totalDiklat',
            'totalPenghargaan',
            'pegawaiPerUnitKerja',
            'gajiMendatang',
            'pangkatMendatang',
            'statistikGolongan',
            'statistikEselon',
            'statistikJenisKelamin',
            'statistikStatus'
        ));
    }

    /**
     * Displays the analytics screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }
}
